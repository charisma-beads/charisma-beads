<?php
namespace Shop\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

class Payment extends AbstractActionController
{   
    /**
     * @var Container
     */
    protected $container;
    
    public function payCheckAction()
    {
        $order = $this->getOrderFromSession();
        \FB::info($order);
    }
    
    public function payPhoneAction()
    {
        
    }
    
    public function payCreditCardAction()
    {
        
    }
    
    public function payPaypalAction()
    {
        
    }
    
    /**
     * @return array
     */
    public function getOrderFromSession()
    {
        if (!$this->container instanceof Container) {
            $this->container = new Container('order');
        }
        
        return $this->container->order;
    }
}
