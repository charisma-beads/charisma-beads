<?php
namespace Shop\Service\Order;

use Shop\Model\Customer as CustomerModel;
use Shop\Model\Order\MetaData;
use UthandoCommon\Service\AbstractRelationalMapperService;

class Order extends AbstractRelationalMapperService
{
    protected $serviceAlias = 'ShopOrder';

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
            'service'       => 'Shop\Service\Order\Lines',
            'getMethod'     => 'getOrderLinesByOrderId',
        ],
    ];
    
    /**
     * @var \Shop\Service\Customer
     */
    protected $customerService;
    
    /**
     * @var \Shop\Service\Order\Line
     */
    protected $orderLineService;
    
    /**
     * @var \Shop\Service\Order\Status
     */
    protected $orderStatusService;
    
    /**
     * @var \Shop\Service\Cart
     */
    protected $cartService;
    
    public function search(array $post)
    {
    	$orders = parent::search($post);
    	 
    	foreach ($orders as $order) {
    		$this->populate($order, ['orderStatus']);
    	}
    	 
    	return $orders;
    }
    
    public function processOrderFromCart(CustomerModel $customer, array $postData)
    {
        $cart = $this->getCartService();
        
        $countryId = (0 == $postData['collect_instore']) ? $customer->getDeliveryAddress()->getCountryId() : null;
        $cart->setShippingCost($countryId);
        
        $shipping = $cart->getShippingCost();
        $taxTotal = $cart->getTaxTotal();
        $cartTotal = $cart->getTotal();
        
        /* @var $orderStatus \Shop\Model\Order\Status */
        $orderStatus = $this->getOrderStatusService()->getStatusByName('Pending');
        $orderNumber = $this->getMapper()->getMaxOrderNumber()['orderNumber'] + 1;
        
        $metadata = new MetaData();
        
        $paymentOption = ucwords(str_replace(
            '_',
            ' ',
            str_replace('pay_', '', $postData['payment_option'])
        ));
        
        $metadata->setPaymentMethod($paymentOption)
            ->setTaxInvoice($this->getShopOptions()->getVatState())
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
            'orderNumber'   => $orderNumber,
            'total'         => $cartTotal,
            'shipping'      => $shipping,
            'taxTotal'      => $taxTotal,
            'metadata'      => $metadata,
        ];
        
        $order = $this->getMapper()->getModel($data);
        
        $orderId = $this->save($order);
        
        /* @var $item \Shop\Model\Cart\Item */
        foreach($cart->getCart() as $item) {
            $lineData = [
            	'orderId'  => $orderId,
                'qty'      => $item->getQuantity(),
                'price'    => $item->getPrice(),
                'tax'      => $item->getTax(),
                'metadata' => $item->getMetadata(),
            ];
            
            $orderLine = $this->getOrderLineService()
                ->getMapper()
                ->getModel($lineData);
            
            $this->getOrderLineService()->save($orderLine);
        }
        
        return $orderId;
    }

    public function updateOrderStatus($orderNumber, $orderStatus)
    {
        $orderNumber = (int) $orderNumber;
        $orderStatus = (int) $orderStatus;

        $order = $this->getMapper()->getOrderByOrderNumber($orderNumber);

        $order->setOrderStatusId($orderStatus);
        $result = $this->save($order);

        return $result;
    }
    
    public function getCustomerOrderByUserId($id, $userId)
    {
        $id = (int) $id;
        $userId = (int) $userId;
        $order = $this->getMapper()->getOrderByUserId($id, $userId);
        
        if ($order) {
            //$this->populate($order, ['orderStatus', 'orderLines']);
        }
        
        return $order;
    }
    
    public function getCustomerOrdersByUserId($userId)
    {
        $userId = (int) $userId;
        $orders = $this->getMapper()->getOrdersByUserId($userId);
        
        foreach ($orders as $order) {
            $this->populate($order, ['orderStatus']);
        }
        
        return $orders;
    }

    public function getCurrentOrders()
    {
        $orders = $this->getMapper()->getCurrentOrders();

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
    
    public function cancelOrder($id, $userId)
    {
    	$id = (int) $id;
    	$userId = (int) $userId;
    	
    	/* @var $order \Shop\Model\Order */
    	$order = $this->getMapper()->getOrderByUserId($id, $userId);
    
    	if ($order) {
    		$orderStatus = $this->getOrderStatusService()
                ->getStatusByName('Cancelled');
    		$order->setOrderStatus($orderStatus->getOrderStatusId());
    		$result = $this->save($order);
    		
    		if ($result) {
    		    return true;
    		}
    	}
    
    	return false;
    }
    
    /**
     * @return \Shop\Service\Customer
     */
    public function getCustomerService()
    {
        if (!$this->customerService) {
            $sl = $this->getServiceLocator();
            $this->customerService = $sl->get('Shop\Service\Customer');
        }
    
        return $this->customerService;
    }
    
    /**
     * @return \Shop\Service\Order\Line
     */
    public function getOrderLineService()
    {
        if (!$this->orderLineService) {
            $sl = $this->getServiceLocator();
            $this->orderLineService = $sl->get('Shop\Service\Order\Line');
        }
    
        return $this->orderLineService;
    }
    
    /**
     * @return \Shop\Options\ShopOptions
     */
    public function getShopOptions()
    {
        return $this->getServiceLocator()->get('Shop\Options\Shop');
    }
    
    /**
     * @return \Shop\Service\Order\Status
     */
    public function getOrderStatusService()
    {
        if (!$this->orderStatusService) {
            $sl = $this->getServiceLocator();
            $this->orderStatusService = $sl->get('Shop\Service\Order\Status');
        }
    
        return $this->orderStatusService;
    }
    
    /**
     * @return \Shop\Service\Cart
     */
    public function getCartService()
    {
        if (!$this->cartService) {
            $sl = $this->getServiceLocator();
            $this->cartService = $sl->get('Shop\Service\Cart');
        }
        
        return $this->cartService;
    }
}
