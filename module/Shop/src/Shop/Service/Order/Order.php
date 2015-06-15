<?php
namespace Shop\Service\Order;

use Shop\Model\Customer\Customer as CustomerModel;
use Shop\Model\Order\MetaData;
use Shop\Model\Order\Order as OrderModel;
use UthandoCommon\Service\AbstractRelationalMapperService;
use Zend\Json\Json;
use Zend\Math\BigInteger\BigInteger;
use Zend\View\Model\ViewModel;

/**
 * Class Order
 * @package Shop\Service\Order
 * @method OrderModel populate()
 * @method \Shop\Mapper\Order\Order getMapper($mapperClass = null, array $options = [])
 */
class Order extends AbstractRelationalMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopOrder';
    
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
        ],
    ];

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
     * @param CustomerModel $customer
     * @param array $postData
     * @return int
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function processOrderFromCart(CustomerModel $customer, array $postData)
    {
        /* @var $cart \Shop\Service\Cart\Cart */
        $cart = $this->getService('ShopCart');

        $countryId = (0 == $postData['collect_instore']) ? $customer->getDeliveryAddress()->getCountryId() : null;
        $cart->setShippingCost($countryId);
        
        $shipping = $cart->getShippingCost();
        $taxTotal = $cart->getTaxTotal();
        $cartTotal = $cart->getTotal();

        /* @var $orderStatusService \Shop\Service\Order\Status */
        $orderStatusService = $this->getService('ShopOrderStatus');
        
        /* @var $orderStatus \Shop\Model\Order\Status */
        $orderStatus = $orderStatusService->getStatusByName('Pending');
        
        $metadata = new MetaData();
        
        $paymentOption = ucwords(str_replace(
            '_',
            ' ',
            str_replace('pay_', '', $postData['payment_option'])
        ));

        /* @var $shopOptions \Shop\Options\ShopOptions */
        $shopOptions = $this->getService('Shop\Options\Shop');
        
        $metadata->setPaymentMethod($paymentOption)
            ->setTaxInvoice($shopOptions->getVatState())
            ->setShippingTax($cart->getShippingTax())
            ->setRequirements($postData['requirements'])
            ->setCustomerName($customer->getFullName(), $customer->getPrefix()->getPrefix())
            ->setBillingAddress($customer->getBillingAddress())
            ->setDeliveryAddress($customer->getDeliveryAddress())
            ->setEmail($customer->getEmail());
        
        if (1 == $postData['collect_instore']) {
            $metadata->setShippingMethod('Collect At Store');
        }
        
        $data = [
        	'customerId'    => $customer->getCustomerId(),
            'orderStatusId' => $orderStatus->getOrderStatusId(),
            //'orderNumber'   => $orderNumber,
            'total'         => $cartTotal,
            'shipping'      => $shipping,
            'taxTotal'      => $taxTotal,
            'metadata'      => $metadata,
        ];
        
        $order = $this->getMapper()->getModel($data);
        
        $orderId = $this->save($order);
        $this->generateOrderNumber($orderId);

        
        /* @var $item \Shop\Model\Cart\Item */
        foreach($cart->getCart() as $item) {
            $lineData = [
            	'orderId'  => $orderId,
                'qty'      => $item->getQuantity(),
                'price'    => $item->getPrice(),
                'tax'      => $item->getTax(),
                'metadata' => $item->getMetadata(),
            ];

            /* @var $orderLineService \Shop\Service\Order\Line */
            $orderLineService = $this->getService('ShopOrderLine');
            $orderLine = $orderLineService
                ->getMapper()
                ->getModel($lineData);
            
            $orderLineService->save($orderLine);
        }
        
        $this->sendEmail($orderId);
        
        return $orderId;
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
        $orderNumber = (int) $orderNumber;
        $orderStatus = (int) $orderStatus;
        /* @var $mapper \Shop\Mapper\Order\Order */
        $mapper = $this->getMapper();
        $order = $mapper->getOrderByOrderNumber($orderNumber);

        $order->setOrderStatusId($orderStatus);
        $result = $this->save($order);

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

    public function getMonthlyTotals($start = null, $end = null)
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
                    $month = ltrim($row->month, '0');

                    for ($i=1; $i < $month; $i++) {
                        $dateObj = \DateTime::createFromFormat('!m', $i);
                        $totalsArray[$c]['data'][] = [$dateObj->format('F'), 0.00];
                    }
                }
            }

            $totalsArray[$c]['data'][] = [$row->monthLong, $row->total];
            $year = $row->year;
        }

        return Json::encode($totalsArray);
    }
    
    /**
     * send order via email
     * 
     * @param unknown $orderId
     */
    public function sendEmail($orderId)
    {
        $order = $this->getById($orderId);
        $order = $this->populate($order, true);
        
        $email = $order->getCustomer()->getEmail();
        /* @var $options \Shop\Options\CheckoutOptions */
        $options = $this->getService('Shop\Options\Checkout');
        /* @var $invoiceOptions \Shop\Options\InvoiceOptions */
        $invoiceOptions = $this->getService('Shop\Options\Invoice');

        $emailView = new ViewModel([
            'order' => $order,
        ]);
        
        $emailView->setTemplate('shop/order/table-view');

        $subject = 'Order Confirmation From %s Order No. %s';
        
        $this->getEventManager()->trigger('mail.send', $this, [
            'recipient'        => [
                'name'      => $order->getCustomer()->getFullName(),
                'address'   => $email,
            ],
            'layout'           => 'shop/email/order',
            'layout_params'    => ['order' => $order],
            'body'             => $emailView,
            'subject'          => sprintf($subject, $invoiceOptions->getMerchantName(), $order->getOrderNumber()),
            'transport'        => $options->getOrderEmail(),
        ]);
        
        if ($options->getSendOrderToAdmin()) {
            $this->getEventManager()->trigger('mail.send', $this, [
                'sender'        => [
                    'name'      => $order->getCustomer()->getFullName(),
                    'address'   => $email,
                ],
                'layout'           => 'shop/email/order',
                'layout_params'    => ['order' => $order],
                'body'             => $emailView,
                'subject'          => sprintf($subject, $order->getCustomer()->getFullName(), $order->getOrderNumber()),
                'transport'        => $options->getOrderEmail(),
            ]);
        }
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
