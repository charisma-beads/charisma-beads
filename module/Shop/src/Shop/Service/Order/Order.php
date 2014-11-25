<?php
namespace Shop\Service\Order;

use Shop\Model\Customer\Customer as CustomerModel;
use Shop\Model\Order\MetaData;
use Shop\Model\Order\Order as OrderModel;
use UthandoCommon\Service\AbstractRelationalMapperService;
use Zend\Math\BigInteger\BigInteger;

class Order extends AbstractRelationalMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopOrder';

    /**
     * @var array
     */
    protected $referenceMap = [
        'customer'      => [
            'refCol'        => 'customerId',
            'service'       => 'Shop\Service\Customer',
            'getMethod'     => 'getCustomerDetailsByCustomerId',
        ],
        'orderStatus'   => [
            'refCol'        => 'orderStatusId',
            'service'       => 'Shop\Service\Order\Status',
        ],
        'orderLines'    => [
            'refCol'        => 'orderId',
            'service'       => 'Shop\Service\Order\Line',
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
        $cart = $this->getService('Shop\Service\Cart');

        $countryId = (0 == $postData['collect_instore']) ? $customer->getDeliveryAddress()->getCountryId() : null;
        $cart->setShippingCost($countryId);
        
        $shipping = $cart->getShippingCost();
        $taxTotal = $cart->getTaxTotal();
        $cartTotal = $cart->getTotal();

        /* @var $orderStatusService \Shop\Service\Order\Status */
        $orderStatusService = $this->getService('Shop\Service\Order\Status');
        
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
            $orderLineService = $this->getService('Shop\Service\Order\Line');
            $orderLine = $orderLineService
                ->getMapper()
                ->getModel($lineData);
            
            $orderLineService->save($orderLine);
        }
        
        return $orderId;
    }

    /**
     * Generate simple order number with check digit.
     * This allows for 999999 orders
     * Format <Date><OrderId padded to 6 digits><Check Digit>
     *
     * @param OrderModel|int $orderModelOrId
     * @return void
     */
    public function generateOrderNumber($orderModelOrId)
    {
        if (!$orderModelOrId instanceof OrderModel) {
            $orderModelOrId = (int) $orderModelOrId;
            $orderModelOrId = $this->getById($orderModelOrId);
        }

        $part1 = $orderModelOrId->getOrderDate()->format('Ymd');
        $part2 = sprintf('%06d', $orderModelOrId->getOrderId());

        $num = join('', [
            $part1, $part2
        ]);

        $bigInt = BigInteger::factory('bcmath');
        $orderModelOrId->setOrderNumber($num . $bigInt->mod($num, 11));

        $this->save($orderModelOrId);
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
            $this->populate($order, ['orderStatus']);
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
    
    public function emailCustomerOrder()
    {
        
    }
    
    public function emailMerchantOrder()
    {
        
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
    
    	if ($order) {
            /* @var $orderStatusService \Shop\Service\Order\Status */
            $orderStatusService = $this->getService('Shop\Service\Order\Status');
    		$orderStatus = $orderStatusService->getStatusByName('Cancelled');
    		$order->setOrderStatus($orderStatus->getOrderStatusId());

    		$result = $this->save($order);
    		
    		if ($result) {
    		    return true;
    		}
    	}
    
    	return false;
    }
}
