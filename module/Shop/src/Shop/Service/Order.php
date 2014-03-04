<?php
namespace Shop\Service;

use Application\Service\AbstractService;
use Shop\Model\Customer as CustomerModel;
use Shop\Model\Order\MetaData;

class Order extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\Order';
    protected $form = 'Shop\Form\Order';
    protected $inputFilter = 'Shop\InputFilter\Order';
    
    /**
     * @var Shop\Service\Customer
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
            ->setRequirements($postData['requirements']);
        
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
    
    public function getCustomerOrderByUserId($id, $userId)
    {
        $id = (int) $id;
        $userId = (int) $userId;
        $order = $this->getMapper()->getOrderByUserId($id, $userId);
        
        if ($order) {
            $this->populate($order, true);
        }
        
        return $order;
    }
    
    public function getCustomerOrdersByUserId($userId)
    {
        $userId = (int) $userId;
        $orders = $this->getMapper()->getOrdersByUserId($userId);
        
        foreach ($orders as $order) {
            $order = $this->populate($order, array('orderStatus'));
        }
        
        return $orders;
    }
    
    /**
     * @param \Shop\Model\Order $model
     * @param bool $children
     * @return \Shop\Model\Order $model
     */
    public function populate($model, $children = false)
    {
        $allChildren = ($children === true) ? true : false;
        $children = (is_array($children)) ? $children : [];
        
        if ($allChildren || in_array('customer', $children)) {
            $id = $model->getCustomerId();
            $model->setCustomer($this->getCustomerService()->getCustomerDetailsByCustomerId($id));
        }
        
        if ($allChildren || in_array('orderStatus', $children)) {
            $id = $model->getOrderStatusId();
            $model->setOrderStatus($this->getOrderStatusService()->getById($id));
        }
        	
        if ($allChildren || in_array('orderLines', $children)) {
            $id = $model->getOrderId();
            $model->setOrderLines($this->getOrderLineService()->getOrderLinesByOrderId($id));
        }
    }
    
    public function emailCustomerOrder()
    {
        
    }
    
    public function emailMerchantOrder()
    {
        
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
            $this->orderLineService = $sl->get('Shop\Service\OrderLine');
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
            $this->orderStatusService = $sl->get('Shop\Service\OrderStatus');
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
