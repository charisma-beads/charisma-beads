<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service\Order;

use Shop\Model\Customer\Customer as CustomerModel;
use Shop\Model\Order\LineInterface;
use Shop\Model\Order\MetaData;
use Shop\Model\Order\Order as OrderModel;
use Shop\Model\Voucher\Code as VoucherCode;
use Shop\Service\Cart\Cart;
use Shop\Service\Voucher\Code;
use Zend\Json\Json;
use Zend\Mail\Protocol\Exception\RuntimeException;
use Zend\Math\BigInteger\BigInteger;
use Zend\View\Model\ViewModel;

/**
 * Class Order
 *
 * @package Shop\Service\Order
 * @method OrderModel populate($model, $children)
 * @method \Shop\Mapper\Order\Order getMapper($mapperClass = null, array $options = [])
 * @method OrderModel getOrderModel()
 */
class Order extends AbstractOrder
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopOrder';

    /**
     * @var string
     */
    protected $lineService = 'orderLines';

    /**
     * @var array
     */
    protected $tags = [
        'order', 'customer', 'order-lines',
        'order-status',
    ];

    /**
     * @var array
     */
    protected $referenceMap = [
        'customer'      => [
            'refCol'        => 'customerId',
            'service'       => 'ShopCustomer',
            'getMethod'     => 'getCustomerDetailsByCustomerId',
        ],
        'orderStatus'   => [
            'refCol'        => 'orderStatusId',
            'service'       => 'ShopOrderStatus',
        ],
        'orderLines'    => [
            'refCol'        => 'orderId',
            'service'       => 'ShopOrderLine',
            'getMethod'     => 'getOrderLinesByOrderId',
            'setMethod'     => 'setEntities',
        ],
    ];

    /**
     * @var array
     */
    protected $orderStatusMap = [
        'pay_check'         => 'Cheque Payment pending',
        'pay_phone'         => 'Waiting for Payment',
        'pay_credit_card'   => 'Card Payment Pending',
        'pay_paypal'        => 'Paypal Payment Pending',
        'pay_pending'       => 'Pending',
    ];

    /**
     * @param $id
     * @param null $col
     * @return OrderModel
     */
    public function getById($id, $col = null)
    {
        $order = parent::getById($id, $col);

        if ($order) {
            $this->populate($order, true);
        }

        return $order;
    }

    /**
     * @param $id
     * @return OrderModel
     */
    public function getOrder($id)
    {
        $order = $this->getById($id);

        $this->setOrderModel($order);

        return $this->getOrderModel();
    }

    /**
     * @param $id
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getCustomerOrdersByCustomerId($id)
    {
        $id = (int) $id;
        /* @var $mapper \Shop\Mapper\Order\Order */
        $mapper = $this->getMapper();

        $orders = $mapper->getOrdersByCustomerId($id);
        foreach ($orders as $order) {
            $this->populate($order, true);
        }

        return $orders;
    }

    /**
     * @param int $orderId
     * @return int
     */
    public function processOrderFromCart($orderId)
    {
        $this->getOrder($orderId);

        /* @var $cart Cart */
        $cart = $this->getService('ShopCart');
        $code = $cart->getContainer()->offsetGet('voucher');

        if ($code) {
            /* @var $voucherService Code */
            $voucherService = $this->getService('ShopVoucherCode');

            $voucher = $voucherService->getVoucherByCode($code);
        } else {
            $voucher = new VoucherCode();
        }

        if ('Collect at Open Day' == $this->getOrderModel()->getMetadata()->getShippingMethod()) {
            $cart->setShippingCost(null, true);
        } else {
            $cart->setShippingCost(
                $this->getOrderModel()
                    ->getCustomer()
                    ->getDeliveryAddress()
                    ->getCountryId()
            );
        }

        $shipping   = $cart->getShippingCost();
        $taxTotal   = $cart->getTaxTotal();
        $discount   = $cart->getCart()->getDiscount();
        $cartTotal  = $cart->getTotal();

        $this->getOrderModel()->setTotal($cartTotal)
            ->setTaxTotal($taxTotal)
            ->setShipping($shipping)
            ->setShippingTax($cart->getShippingTax())
            ->setDiscount($discount)
            ->getMetadata()->setVoucher($voucher);

        /* @var $orderLineService \Shop\Service\Order\Line */
        $orderLineService = $this->getService('ShopOrderLine');
        $orderLineService->processLines($cart->getCart(), $orderId);

        $this->loadItems($this->getOrderModel());

        //$this->recalculateTotals();
        
        $result = $this->save($this->getOrderModel());

        $this->sendEmail($orderId);

        $order = $this->getOrderModel();
        $argv = compact('voucher', 'order');
        $argv = $this->prepareEventArguments($argv);
        $this->getEventManager()->trigger('voucher.use', $this, $argv);
        
        return $orderId;
    }

    /**
     * @param CustomerModel $customer
     * @param $postData
     * @return OrderModel
     */
    public function create(CustomerModel $customer, $postData)
    {
        $collectInStore = ($postData['collect_instore']) ? true : false;

        /* @var $orderStatusService \Shop\Service\Order\Status */
        $orderStatusService = $this->getService('ShopOrderStatus');

        /* @var $orderStatus \Shop\Model\Order\Status */
        $orderStatus = $orderStatusService->getStatusByName($this->orderStatusMap[$postData['payment_option']]);

        $metadata = new MetaData();

        $paymentOption = ucwords(str_replace(
            '_',
            ' ',
            str_replace('pay_', '', $postData['payment_option'])
        ));

        $shopOptions = $this->getShopOptions();

        $metadata->setPaymentMethod($paymentOption)
            ->setTaxInvoice($shopOptions->isVatState())
            ->setRequirements($postData['requirements'])
            ->setCustomerName($customer->getFullName(), $customer->getPrefix()->getPrefix())
            ->setBillingAddress($customer->getBillingAddress())
            ->setDeliveryAddress($customer->getDeliveryAddress())
            ->setEmail($customer->getEmail());

        if (true === $collectInStore) {
            $metadata->setShippingMethod('Collect at Open Day');
        }

        $data = [
            'customerId'    => $customer->getCustomerId(),
            'orderStatusId' => $orderStatus->getOrderStatusId(),
            'total'         => 0,
            'shipping'      => 0,
            'taxTotal'      => 0,
            'shippingTax'   => 0,
            'orderDate'     => New \DateTime(),
            'metadata'      => $metadata,
            'customer'      => $customer,
            'orderStatus'   => $orderStatus,
        ];

        $order = $this->getMapper()->getModel($data);
        $orderId = $this->save($order);
        $this->generateOrderNumber($orderId);

        return $orderId;
    }

    /**
     * Recalculate totals of order
     */
    public function calculateTotals()
    {
        $sub = 0;
        $tax = 0;
        $this->getOrderModel()->setTaxTotal(0);

        /* @var $lineItem \Shop\Model\Order\Line */
        foreach($this->getOrderModel() as $lineItem) {
            $sub = $sub + (($lineItem->getPrice()) * $lineItem->getQuantity());
            $this->getOrderModel()->setTaxTotal(
                $this->getOrderModel()->getTaxTotal() + ($lineItem->getTax() * $lineItem->getQuantity())
            );
        }

        $this->getOrderModel()->setSubTotal($sub);

        $shipping = $this->getShippingService();

        if ($this->getOrderModel()->getMetadata()->getShippingMethod() == 'Collect at Open Day') {
            $shipping->setCountryId(0);
        } else {
            $shipping->setCountryId($this->getOrderModel()->getMetadata()->getDeliveryAddress()->getCountryId());
        }

        $cost = $shipping->calculateShipping($this->getOrderModel());

        $this->getOrderModel()->setShipping($cost);
        $this->setShippingTax($shipping->getShippingTax());

        $this->getOrderModel()->setTotal(
            $this->getOrderModel()->getSubTotal() + $this->getOrderModel()->getShipping()
        );
        $this->getOrderModel()->setTaxTotal(
            $this->getOrderModel()->getTaxTotal() + $this->getOrderModel()->getShippingTax()
        );

        $this->getEventManager()->trigger('order.voucher.check', $this);

        $this->save($this->getOrderModel());
    }

    /**
     * @param LineInterface|null $line
     * @return void
     */
    public function persist(LineInterface $line = null)
    {
        $order = $this->getOrderModel();
        $order->setOrderDate();

        if (null === $line->getOrderId()) {
            $line->setCartId($order->getOrderId());
        }

        $priceTax = $this->calculateTax($line);
        $line->setPrice($priceTax['price']);
        $line->setTax($priceTax['tax']);

        $this->getRelatedService($this->lineService)->save($line);
    }

    /**
     * Generate simple order number with check digit.
     * This allows for 9999999 orders
     * Format <Date><OrderId padded to 7 digits><Check Digit>
     *
     * @param OrderModel|int $orderModelOrId
     * @return OrderModel
     */
    public function generateOrderNumber($orderModelOrId)
    {
        if (!$orderModelOrId instanceof OrderModel) {
            $orderModelOrId = (int) $orderModelOrId;
            $orderModelOrId = $this->getById($orderModelOrId);
        }

        $part1 = $orderModelOrId->getOrderDate()->format('Ymd');
        $part2 = sprintf('%07d', $orderModelOrId->getOrderId());

        $num = join('', [
            $part1, $part2
        ]);

        $bigInt = BigInteger::factory('bcmath');
        $checkSum = $bigInt->mod($num, 11);
        $checkSum = $bigInt->mod($checkSum, 10);
        $orderModelOrId->setOrderNumber($num . $checkSum);

        $this->save($orderModelOrId);
        
        return $orderModelOrId;
    }

    /**
     * @param int $orderNumber
     * @param int $orderStatus
     * @return int
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function updateOrderStatus($orderNumber, $orderStatus)
    {
        /* @var $options \Shop\Options\OrderOptions */
        $options = $this->getService('Shop\Options\Order');

        $orderNumber = (string) $orderNumber;
        $orderStatus = (int) $orderStatus;
        /* @var $mapper \Shop\Mapper\Order\Order */
        $mapper = $this->getMapper();
        $order = $mapper->getOrderByOrderNumber($orderNumber);
        
        $order->setOrderStatusId($orderStatus);
        $result = $this->save($order);

        if ($result && $options->isEmailCustomerOnStatusChange()) {
            $this->populate($order, true);

            if (!$order->getCustomer()->getEmail()) {
                return $result;
            }

            $shopOptions = $this->getShopOptions();

            $subject = 'Order Status From %s Order No. %s';

            $emailView = new ViewModel([
                'order' => $order,
            ]);

            $emailView->setTemplate('shop/email/status-change');

            try {
                $this->getEventManager()->trigger('mail.send', $this, [
                    'recipient'        => [
                        'name'      => $order->getCustomer()->getFullName(),
                        'address'   => $order->getCustomer()->getEmail(),
                    ],
                    'layout'           => 'shop/email/order',
                    'layout_params'    => ['order' => $order],
                    'body'             => $emailView,
                    'subject'          => sprintf($subject, $shopOptions->getMerchantName(), $order->getOrderNumber()),
                    'transport'        => $options->getOrderEmail(),
                ]);
            } catch (RuntimeException $e) {
                return $result;
            }
        }

        return $result;
    }

    /**
     * @param int $id
     * @param int $userId
     * @return mixed
     */
    public function getCustomerOrderByUserId($id, $userId)
    {
        $id = (int) $id;
        $userId = (int) $userId;
        /* @var $mapper \Shop\Mapper\Order\Order */
        $mapper = $this->getMapper();
        $order = $mapper->getOrderByUserId($id, $userId);
        
        if ($order) {
            $this->populate($order, true);
        }

        return $order;
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function getCustomerOrdersByUserId($userId)
    {
        $userId = (int) $userId;
        /* @var $mapper \Shop\Mapper\Order\Order */
        $mapper = $this->getMapper();
        $orders = $mapper->getOrdersByUserId($userId);
        
        foreach ($orders as $order) {
            $this->populate($order, true);
        }
        
        return $orders;
    }

    /**
     * @return mixed
     */
    public function getCurrentOrders()
    {
        /* @var $mapper \Shop\Mapper\Order\Order */
        $mapper = $this->getMapper();
        $orders = $mapper->getCurrentOrders();

        foreach ($orders as $order) {
            $this->populate($order, ['customer', 'orderStatus']);
        }

        return $orders;
    }

    /**
     * @param null|string $start
     * @param null|string $end
     * @param string $monthFormat
     * @return string
     */
    public function getMonthlyTotals($start = null, $end = null, $monthFormat = 'm')
    {
        $startDate = new \DateTime($start);
        $start = $startDate->format('Y-m-d');

        if ($end) {
            $endDate = new \DateTime($end);
            $end = $endDate->format('Y-m-d');
        }

        $resultSet = $this->getMapper()
            ->getMonthlyTotals($start, $end);

        $totalsArray = [];
        $year = null;

        $c = -1;

        foreach ($resultSet as $row) {

            // if we start with a new year.
            if ($year != $row->year) {
                $c++;
                $totalsArray[$c]['label'] = $row->year;

                // if row doesn't start at beginning of year the pad missing months
                if ($row->month != '01') {

                    $monthDigit = (int) ltrim($row->month, '0');

                    for ($i=1; $i < $monthDigit; $i++) {
                        $dateObj = \DateTime::createFromFormat('!m', $i);
                        $month = $dateObj->format($monthFormat);
                        $totalsArray[$c]['data'][] = [$month, 0.00];
                        $totalsArray[$c]['numOrders'][$month] = 0;
                    }
                }
            }

            $dateObj = \DateTime::createFromFormat('!m', $row->month);
            $month = $dateObj->format($monthFormat);

            $totalsArray[$c]['data'][] = [$month, $row->total];
            $totalsArray[$c]['numOrders'][$month] = $row->numOrders;
            $year = $row->year;
        }

        return Json::encode($totalsArray);
    }

    /**
     * send order via email
     *
     * @param $orderId
     * @return \Exception|null|RuntimeException
     */
    public function sendEmail($orderId)
    {
        $order = $this->getById($orderId);
        $order = $this->populate($order, true);
        $emailResult = null;
        
        $email = $order->getCustomer()->getEmail();
        /* @var $options \Shop\Options\OrderOptions */
        $options = $this->getService('Shop\Options\Order');
        $shopOptions = $this->getShopOptions();

        $emailView = new ViewModel([
            'order' => $order,
        ]);
        
        $emailView->setTemplate('shop/order/table-view');

        $subject = 'Order Confirmation From %s Order No. %s';

        if ($email) {
            try {
                $this->getEventManager()->trigger('mail.send', $this, [
                    'recipient' => [
                        'name' => $order->getCustomer()->getFullName(),
                        'address' => $email,
                    ],
                    'layout' => 'shop/email/order',
                    'layout_params' => ['order' => $order],
                    'body' => $emailView,
                    'subject' => sprintf($subject, $shopOptions->getMerchantName(), $order->getOrderNumber()),
                    'transport' => $options->getOrderEmail(),
                ]);
            } catch (RuntimeException $e) {
                $emailResult = $e;
            }
        }
        
        if ($options->getSendOrderToAdmin()) {
            $sender = [];

            if ($email) {
                $sender = [
                    'sender'        => [
                        'name'      => $order->getCustomer()->getFullName(),
                        'address'   => $email,
                    ],
                ];
            }
            $this->getEventManager()->trigger('mail.send', $this, array_merge([
                'layout'           => 'shop/email/order',
                'layout_params'    => ['order' => $order],
                'body'             => $emailView,
                'subject'          => sprintf($subject, $order->getCustomer()->getFullName(), $order->getOrderNumber()),
                'transport'        => $options->getOrderEmail(),
            ], $sender));
        }

        return $emailResult;
    }

    /**
     * @param int $id
     * @param int $userId
     * @return bool
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function cancelOrder($id, $userId)
    {
    	$id = (int) $id;
    	$userId = (int) $userId;

        /* @var $mapper \Shop\Mapper\Order\Order */
        $mapper = $this->getMapper();
    	
    	/* @var $order OrderModel */
    	$order = $mapper->getOrderByUserId($id, $userId);
        //$this->populate($order, true);
    
    	if ($order) {
            /* @var $orderStatusService \Shop\Service\Order\Status */
            $orderStatusService = $this->getService('Shop\OrderStatus');
    		$orderStatus = $orderStatusService->getStatusByName('Cancelled');
    		$order->setOrderStatusId($orderStatus->getOrderStatusId());

    		$result = $this->save($order);
    		
    		if ($result) {
    		    return true;
    		}
    	}
    
    	return false;
    }
}
