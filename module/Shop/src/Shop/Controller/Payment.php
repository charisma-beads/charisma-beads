<?php
namespace Shop\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

class Payment extends AbstractActionController
{   
    public function paymentAction()
    {
        $container = new Container('order_completed');
        $params = $container->order;
        \FB::info($params);
    }
    
    public function payCheckAction()
    {
        
    }
    
    public function payPhoneAction()
    {
        
    }
    
    public function payCreditCardAction()
    {
        
    }
}
