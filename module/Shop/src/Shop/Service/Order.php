<?php
namespace Shop\Service;

use Application\Service\AbstractService;
use Shop\Model\Customer as CustomerModel;

class Order extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\Order';
    protected $form = 'Shop\Form\Order';
    protected $inputFilter = 'Shop\InputFilter\Order';
    
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
    
    public function processOrderFromCart(CustomerModel $customer, $collect = null)
    {
        $cart = $this->getCartService();
        
        $countryId = (!$collect) ? $customer->getDeliveryAddress()->getCountryId() : null;
        $cart->setShippingCost($countryId);
        
        $shipping = $cart->getShippingCost();
        $taxTotal = $cart->getTaxTotal();
        $cartTotal = $cart->getTotal();
        
        /* @var $orderStatus \Shop\Model\Order\Status */
        $orderStatus = $this->getOrderStatusService()->getStatusByName('Pending');
        $orderNumber = $this->getMapper()->getMaxOrderNumber()['orderNumber'] + 1;
        
        $data = array(
        	'customerId'    => $customer->getCustomerId(),
            'orderStatusId' => $orderStatus->getOrderStatusId(),
            'orderNumber'   => $orderNumber,
            'total'         => $cartTotal,
            'shipping'      => $shipping,
            'vatTotal'      => $taxTotal,
            'vatInvoice'    => $this->getShopOptions()->getVatState(),
        );
        
        $order = $this->getMapper()->getModel($data);
        
        $orderId = $this->save($order);
        
        /* @var $item \Shop\Model\Cart\Item */
        foreach($cart->getCart() as $item) {
            $lineData = array(
            	'orderId'  => $orderId,
                'qty'      => $item->getQuantity(),
                'price'    => $item->getPrice(),
                'tax'      => $item->getTax(),
                'metadata' => $item->getMetadata(),
            );
            
            $orderLine = $this->getOrderLineService()
                ->getMapper()
                ->getModel($lineData);
            
            $this->getOrderLineService()->save($orderLine);
        }
        
        return $orderId;
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
