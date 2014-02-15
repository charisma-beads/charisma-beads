<?php
namespace Shop\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class Payment extends AbstractActionController
{   
    public function paymentAction()
    {
        $params = $this->params()->fromRoute('shop/payment');
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
