<?php

namespace Shop\Controller;

use Shop\Service\CreditCardService;
use Shop\Service\OrderService;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Common\Service\ServiceTrait;
use Shop\Model\OrderModel;
use Laminas\Http\PhpEnvironment\Response;
use Laminas\Form\Form;

/**
 * Class Payment
 *
 * @package Shop\Controller
 */
class PaymentController extends AbstractActionController
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
        
        if (!$order instanceof OrderModel) {
            return $this->redirect()->toRoute('shop/order');
        }
        
        $prg = $this->prg();
        $service = $this->getService(CreditCardService::class);
        
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

    /**
     * @param null $orderId
     * @return OrderModel
     */
    private function getOrder($orderId = null)
    {
        $orderId = ($orderId) ?: $this->order()->getOrderFromSession()['orderId'];
        $userId = $this->identity()->getUserId();
        
        return $this->getService(OrderService::class)
            ->getCustomerOrderByUserId($orderId, $userId);
    }
}
