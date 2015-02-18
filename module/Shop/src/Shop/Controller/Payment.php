<?php
namespace Shop\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use UthandoCommon\Controller\ServiceTrait;
use Shop\Model\Order\Order;

class Payment extends AbstractActionController
{
    use ServiceTrait;
    
    public function indexAction()
    {
        $paymentOption = $this->params()->fromRoute('paymentOption');
        $order = $this->getOrder();
        
        $viewModel = new ViewModel([
            'order' => $order,
        ]);
        
        switch ($paymentOption) {
            case 'pay-paypal' :
                return $this->redirect()->toRoute('shop/paypal', [
                    'action' => 'process',
                    'orderId' => $order->getOrderId()
                ]);
                break;
            case 'pay-credit-card':
                return $this->redirect()->toRoute('shop/payment/process-credit-card', [
                    'orderId' => $order->getOrderId()
                ]);
                break;
            case 'pay-phone':
                $viewModel->setTemplate('shop/payment/phone');
                break;
            default:
                $viewModel->setTemplate('shop/payment/cheque');
                break; 
        }
        
        return $viewModel;
    }
    
    public function processCreditCardAction()
    {
        $order = $this->getOrder($this->params()->fromRoute('orderId'));
        
        if (!$order instanceof Order) {
            return $this->redirect()->toRoute('shop/order');
        }
        
        $viewModel = new ViewModel([
            'order' => $order
        ]);
        
        $formElementManager = $this->getService('FormElementManager');
        $form = $formElementManager->get('ShopPaymentCreditCard');
        $viewModel->setTemplate('shop/payment/credit-card');
        $data = [
            'total' => $order->getTotal(),
        ];
        
        $form->setData($data);
        $viewModel->setVariable('form', $form);
        
        
        return $viewModel;
    }
    
    private function getOrder($orderId = null)
    {
        $orderId = ($orderId) ?: $this->order()->getOrderFromSession()['orderId'];
        $userId = $this->identity()->getUserId();
        
        return $this->getService('ShopOrder')
            ->getCustomerOrderByUserId($orderId, $userId);
    }
}
