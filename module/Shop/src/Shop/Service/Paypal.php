<?php
namespace Shop\Service;

use PayPal\Exception\PayPalConnectionException;
use Shop\Model\Order\Order as OrderModel;
use Shop\Options\PaypalOptions;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Payer;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ShippingAddress;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Shop\Service\Tax\Tax;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use PayPal\Api\Measurement;

class Paypal implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
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
     * $payment = [
            'intent' => 'sale',
            'payer' => [
                'paymentMethod' => 'paypal',
            ],
            'redirectUrls' => [
                'cancelUrl' => 'http://localhost/payapl/cancel',
                'returnUrl' => 'http://localhost/payapl/success',
            ],
            'transactions' => [
                [
                    'itemList' => [
                        'items' => [
                            [
                                'name' => 'blue pants',
                                'sku' => 'bp01',
                                'price' => '10.00',
                                'quantity' => '1',
                                'currency' => 'GBP',
                                'description' => 'some description'                            ],
                        ],
                        'shippingAddress' => [
                            'line1' => '20 Bogus Lane',
                            'line2' => '',
                            'city' => 'Dubius Town',
                            'state' => 'nowhere',
                            'PostalCode' => 'AA11 1AA',
                            'CountryCode' => 'GB',
                            'ReciptentName' => 'Mr. E Coli',
                            'phone' => '0123456789',
                        ],
                ],
                'amount' => [
                    'currency' => 'GBP',
                    'total' => '12.00',
                        'details' => [
                            'shipping' => '2.00',
                            'tax' => '0.00',
                            'subtotal' => '10.00',
                       ],
                    ],
                    'description' => 'Payment for order No: 1',
                ],
            ],
        ];
     *
     * @param OrderModel $order
     * @return array
     */
    public function createPayment(OrderModel $order)
    {   
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
            
            $name = $orderItem->getMetadata()->getName();
            
            //if ($orderItem->getMetadata()->getPostUnit() > 0) {
                $weight = new Measurement();
                $weight->setValue($orderItem->getMetadata()->getPostUnit());
                $weight->setUnit('grams');
            //}
            
            $item->setName($orderItem->getMetadata()->getName());
            $item->setSku($orderItem->getMetadata()->getSku());
            $item->setDescription($orderItem->getMetadata()->getDescription());
            $item->setPrice($price);
            $item->setTax($tax);
            $item->setQuantity($orderItem->getQty());
            $item->setCurrency($options->getCurrencyCode());
            $item->setWeight($weight);
            
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

        } catch (PayPalConnectionException $ex) {
            // Don't spit out errors or use "exit" like this in production code
            echo '<pre>';print_r(json_decode($payment->toJSON()));
            echo '<pre>';print_r(json_decode($ex->getData()));exit;
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
    
    public function executePayment(OrderModel $order, $payerId)
    {
        $paymentId = $order->getMetadata()->getPaymentId();
        $payment = Payment::get($paymentId, $this->getApiContent());
        
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);
        
        $payment = $payment->execute($execution, $this->getApiContent());
            
        if ($payment->getState() === 'approved') {
            /* @var $orderStatus \Shop\Model\Order\Status */
            $orderStatus = $this->getOrderStatusService()
                ->getStatusByName('Paypal Payment Completed');
            $order->setOrderStatusId($orderStatus->getOrderStatusId());
        }
        
        return [
            'payment'   => $payment,
            'order'     => $order,
        ];
    }
    
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
    
    public function getOrderStatusService()
    {
        if (!$this->orderStatusService) {
            $service = $this->getServiceLocator()->get('Shop\Service\Order\Status');
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
