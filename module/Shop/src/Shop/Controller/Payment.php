<?php
namespace Shop\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class Payment extends AbstractActionController
{
    public function payCheckAction()
    {
        $order = $this->getOrder();
    }

    public function payPhoneAction()
    {
        $order = $this->getOrder();
    }

    public function payCreditCardAction()
    {
        $order = $this->getOrder();
    }

    public function payPaypalAction()
    {
        return $this->redirect()->toRoute('shop/paypal', [
            'action' => 'process'
        ]);
    }
    
    private function getOrder()
    {
        $orderId = $this->order()->getOrderFromSession()['orderId'];
        $userId = $this->identity()->getUserId();
        
        $order = $this->getOrderService()
            ->getCustomerOrderByUserId($orderId, $userId);
    }
}
