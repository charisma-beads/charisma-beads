<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Payment
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service\Payment;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Payer;
use PayPal\Api\RedirectUrls;
use PayPal\Api\RelatedResources;
use PayPal\Api\Sale;
use PayPal\Api\ShippingAddress;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Shop\Model\Order\Order as OrderModel;
use Shop\Options\PaypalOptions;
use Shop\Service\Tax\Tax;
use Shop\ShopException;
use UthandoCommon\Service\AbstractService;
use UthandoCommon\Stdlib\StringUtils;

/**
 * Class Paypal
 *
 * @package Shop\Service\Payment
 */
class Paypal extends AbstractService
{
    /**
     * @var PaypalOptions
     */
    protected $options;
    
    /**
     * @var ApiContext
     */
    protected $apiContext;
    
    /**
     * @var \Shop\Service\Order\Status
     */
    protected $orderStatusService;

    /**
     * @var Tax
     */
    protected $taxService;

    /**
     * Should this be done by hydrators?
     *
     * @param OrderModel $order
     * @return array
     * @throws ShopException
     */
    public function createPayment(OrderModel $order)
    {
        $orderStatus = $order->getOrderStatus()->getOrderStatus();
        $pending = (StringUtils::endsWith($orderStatus, 'Pending') || 'Waiting for Payment' === $orderStatus) ?  true : false;

        if ($order->getMetadata()->getPaymentId() && false === $pending) {
            throw new ShopException('Payment already processed');
        }

        $options = $this->getOptions();
        
        // set payment method
        $payer = new Payer();
        $payer->setPaymentMethod($options->getPaymentMethod());
        
        // set payment amount of order
        $details = new Details();
        $details->setShipping(number_format($order->getShipping(), 2));
        $details->setTax(number_format($order->getTaxTotal() - $order->getMetadata()->getShippingTax(), 2));
        
        $subtotal = $order->getTotal() - ($order->getShipping() + ($order->getTaxTotal() - $order->getMetadata()->getShippingTax()));
        $details->setSubtotal(number_format($subtotal, 2));
        
        $amount = new Amount();
        $amount->setCurrency($options->getCurrencyCode());
        $amount->setTotal(number_format($order->getTotal(), 2));
        $amount->setDetails($details);
        
        // set shipping address
        $shippingAddress = new ShippingAddress();
        $deliveryAddress = $order->getMetadata()->getDeliveryAddress();
        
        if ($deliveryAddress->getAddress3() != '') {
            $line2 = join(', ', [
                $deliveryAddress->getAddress2(),
                $deliveryAddress->getAddress3(),
            ]);
        } else {
            $line2 = $deliveryAddress->getAddress2();
        }
        
        $shippingAddress->setLine1($deliveryAddress->getAddress1());
        $shippingAddress->setLine2($line2);
        
        $shippingAddress->setCity($deliveryAddress->getCity());
        $shippingAddress->setState($deliveryAddress->getCounty());
        $shippingAddress->setPostalCode($deliveryAddress->getPostcode());
        
        $shippingAddress->setCountryCode($deliveryAddress->getCountry()->getCode());
        $shippingAddress->setRecipientName($order->getMetadata()->getCustomerName());
        $shippingAddress->setPhone($deliveryAddress->getPhone());
        
        
        // get order items.
        $items = [];

        $taxService = $this->getTaxService();
        
        /* @var $orderItem \Shop\Model\Order\Line */
        foreach ($order->getOrderLines() as $orderItem) {
            $item = new Item();

            if ($order->getMetadata()->getTaxInvoice()) {
                $taxService->setTaxState($order->getMetadata()->getTaxInvoice())
                    ->setTaxInc($orderItem->getMetadata()->getVatInc());

                $taxService->addTax($orderItem->getPrice(), $orderItem->getTax(true));
                $price = $taxService->getPrice();
                $tax = $taxService->getTax();

            } else {
                $price = number_format($orderItem->getPrice(), 2);
                $tax = number_format(0, 2);
            }
            
            $item->setName($orderItem->getMetadata()->getName());
            $item->setSku($orderItem->getMetadata()->getSku());
            $item->setDescription($orderItem->getMetadata()->getDescription());
            $item->setPrice($price);
            $item->setTax($tax);
            $item->setQuantity($orderItem->getQty());
            $item->setCurrency($options->getCurrencyCode());
            
            $items[] = $item;
        }
        
        $itemList = new ItemList();
        $itemList->setItems($items);
        $itemList->setShippingAddress($shippingAddress);
        
        // add items to new transaction
        $transaction = new Transaction();
        $transaction->setItemList($itemList);
        $transaction->setAmount($amount);
        $transaction->setDescription('Payment for order No:' . $order->getOrderNumber());
        $transaction->setInvoiceNumber($order->getOrderNumber(false));
        
        // add redirect urls
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setCancelUrl($this->buildUrl('cancel', $order->getOrderId()));
        $redirectUrls->setReturnUrl($this->buildUrl('success', $order->getOrderId()));
        
        // now create payment to sent to paypal.
        $payment = new Payment();
        $payment->setIntent('sale');
        $payment->setPayer($payer);
        $payment->setRedirectUrls($redirectUrls);
        $payment->setTransactions([$transaction]);

        try {
            $payment->create($this->getApiContent());
        } catch (\Exception $e) {
            $paypalException = new PaymentException(
                'An error occurred when trying to execute your PayPal payment, please contact the shop to process your payment',
                $e->getCode(),
                $e
            );

            $paypalException->setOrder($order)
                ->setPayment($payment);

            throw $paypalException;
        }
        

        $order->getMetadata()->setPaymentId($payment->getId());
        
        /* @var $orderStatus \Shop\Model\Order\Status */
        $orderStatus = $this->getOrderStatusService()
            ->getStatusByName('Paypal Payment Pending');
        
        $order->setOrderStatusId($orderStatus->getOrderStatusId());

        $redirectUrl = null;
        
        foreach($payment->getLinks() as $link) {
        	if($link->getRel() == 'approval_url') {
        		$redirectUrl = $link->getHref();
        	}
        }
        
        return [
            'order'         => $order,
            'redirectUrl'   => $redirectUrl
        ];
    }

    /**
     * Execute payment and get it's status
     *
     * @param OrderModel $order
     * @param $payerId
     * @return OrderModel
     * @throws ShopException
     */
    public function executePayment(OrderModel $order, $payerId)
    {
        $paymentId = $order->getMetadata()->getPaymentId();
        $payment = $this->getPayment($paymentId);

        if ($this->getRelatedResource($payment)->getSale() instanceof Sale) {
            throw new ShopException('Payment already processed');
        }
        
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        try {
            $payment = $payment->execute($execution, $this->getApiContent());
        } catch (\Exception $e) {
            $paypalException = new PaymentException(
                'An error occurred when trying to execute your PayPal payment, please contact the shop to process your payment',
                $e->getCode(),
                $e
            );

            $paypalException->setOrder($order)
                ->setPayment($payment);

            throw $paypalException;
        }

        $paymentState = $payment->getState();
        /* @var Transaction $transaction */
        $saleState = $this->getRelatedResource($payment)
            ->getSale()
            ->getState();
            
        if ('approved' === $paymentState && 'completed' === $saleState) {
            /* @var $orderStatus \Shop\Model\Order\Status */
            $orderStatus = $this->getOrderStatusService()
                ->getStatusByName('Paypal Payment Completed');
            $order->setOrderStatusId($orderStatus->getOrderStatusId());
        }

        return $order;
    }

    /**
     * @param Payment $payment
     * @return RelatedResources
     */
    public function getRelatedResource(Payment $payment)
    {
        /* @var Transaction $transaction */
        $transaction = $payment->getTransactions()[0];
        /* @var RelatedResources $relatedResource */

        if (1 === count($transaction->getRelatedResources())) {
            return $transaction->getRelatedResources()[0];
        }

        return new RelatedResources();
    }

    /**
     * @param $paymentId
     * @return Payment
     */
    public function getPayment($paymentId)
    {
        return Payment::get($paymentId, $this->getApiContent());
    }

    /**
     * @return ApiContext
     */
    public function getApiContent()
    {
        if (!$this->apiContext instanceof ApiContext) {
            $options = $this->getOptions();
            
            $apiContext = new ApiContext(new OAuthTokenCredential(
            		$options->getClientId(),
            		$options->getSecret()
            ));

            $apiContext->setConfig([
                'mode'              => $options->getMode(),
                'log.LogEnabled'    => $options->getLogEnabled(),
                'log.FileName'      => $options->getLog(),
                'log.LogLevel'      => $options->getLogLevel(),
    		]);
            
            $this->apiContext = $apiContext;
        }
        
        return $this->apiContext;
    }

    /**
     * @param $action
     * @param $orderId
     * @return mixed
     */
    public function buildUrl($action, $orderId)
    {
        $viewManager = $this->getServiceLocator()
            ->get('ViewHelperManager');
        
        $url = $viewManager->get('Url');
        $scheme = $viewManager->get('ServerUrl');
        
        $url = $url('shop/paypal', [
            'action'    => $action,
            'orderId'   => $orderId,
		]);
        
        return $scheme($url);
    }

    /**
     * @return array|object|\Shop\Service\Order\Status
     */
    public function getOrderStatusService()
    {
        if (!$this->orderStatusService) {
            $service = $this->getServiceLocator()->get('ShopOrderStatus');
            $this->orderStatusService = $service;
        }
        
        return $this->orderStatusService;
    }

    /**
     * @return Tax
     */
    public function getTaxService()
    {
        if (! $this->taxService instanceof Tax) {
            $sl = $this->getServiceLocator();
            $this->taxService = $sl->get('Shop\Service\Tax');
        }

        return $this->taxService;
    }
    
    /**
     * @return PaypalOptions
     */
    public function getOptions()
    {
        if (!$this->options instanceof PaypalOptions) {
            $options = $this->getServiceLocator()->get('Shop\Options\Paypal');
            $this->options = $options;
        }
        
        return $this->options;
    }

}
