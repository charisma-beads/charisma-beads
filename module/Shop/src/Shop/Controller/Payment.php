<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use UthandoCommon\Service\ServiceTrait;
use Shop\Model\Order\Order;
use Zend\Http\PhpEnvironment\Response;
use Zend\Form\Form;

/**
 * Class Payment
 *
 * @package Shop\Controller
 */
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
                    'orderId' => $order->getOrderId(),
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
        
        $prg = $this->prg();
        $service = $this->getService('ShopPaymentCreditCard');
        
        $viewModel = new ViewModel();
        $viewModel->setTemplate('shop/payment/credit-card');

        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            $data = [
                'total' => $order->getTotal(),
                'orderId' => $order->getOrderId(),
                'address' => $order->getCustomer()->getBillingAddress()->getArrayCopy(),
            ];

            $options = [
                'billing_country' => $order->getCustomer()
                    ->getBillingAddress()
                    ->getCountry()
                    ->getCode(),
            ];
            
            $viewModel->setVariables([
                'order' => $order,
                'form' => $service->getForm(null, $options)->setData($data),
            ]);

            return $viewModel;
        }

        $result = $service->process($prg);


        if ($result instanceof Form) {
            $this->flashMessenger()->addErrorMessage('There were one or more issues with your submission. Please correct them as indicated below.');
            $viewModel->setVariables([
                'form' => $result,
                'order' => $order,
            ]);
            
            return $viewModel;
        }
        
        $viewModel->setTemplate('shop/payment/credit-card-success');
        return $viewModel->setVariable('order', $order);
    }
    
    private function getOrder($orderId = null)
    {
        $orderId = ($orderId) ?: $this->order()->getOrderFromSession()['orderId'];
        $userId = $this->identity()->getUserId();
        
        return $this->getService('ShopOrder')
            ->getCustomerOrderByUserId($orderId, $userId);
    }
}
