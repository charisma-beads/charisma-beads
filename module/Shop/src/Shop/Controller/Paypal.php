<?php
namespace Shop\Controller;

use PayPal\Exception\PPConnectionException;
use Shop\Service\Paypal as PaypalService;
use Shop\Service\Order as OrderService;
use UthandoCommon\Controller\SetExceptionMessages;
use Zend\Mvc\Controller\AbstractActionController;

class Paypal extends AbstractActionController
{
    use SetExceptionMessages;
    
    /**
     * @var PaypalService
     */
    protected $paypalService;
    
    /**
     * @var OrderService
     */
    protected  $orderService;
    
    public function processAction()
    {
        $orderId = $this->order()->getOrderFromSession()['orderId'];
        $userId = $this->identity()->getUserId();
        
        $order = $this->getOrderService()
            ->getCustomerOrderByUserId($orderId, $userId);
        
        try {
            $result = $this->getPaypalService()->createPayment($order);
            
            $update = $this->getOrderService()->save($result['order']);
        }
        catch (PPConnectionException $e) {
        	$this->setExceptionMessages($e);
        	return ['order' => $order];
        }
        
        return $this->redirect()->toUrl($result['redirectUrl']);
    }

    public function successAction()
    {
        $orderId = $this->params()->fromRoute('orderId', 0);
        $userId = $this->identity()->getUserId();
        $payerId = $this->params()->fromQuery('PayerID');
        
        $order = $this->getOrderService()
            ->getCustomerOrderByUserId($orderId, $userId);
        
        try {
            $result = $this->getPaypalService()->executePayment($order, $payerId);
            
            $update = $this->getOrderService()->save($result['order']);
            
            $order = (!$update) ?: $this->getOrderService()
                ->getCustomerOrderByUserId($orderId, $userId);
            
            return [
                'order' => $order,
                'payment' => $result['payment'],
            ];
        }
        catch (PPConnectionException $e) {
            $this->setExceptionMessages($e);
            return ['order' => $order];
        }
    }

    public function cancelAction()
    {
        $orderId = $this->params()->fromRoute('orderId', 0);
        $userId = $this->identity()->getUserId();
        
        $result = $this->getOrderService()
            ->cancelOrder($orderId, $userId);

        $order = (!$result) ?: $this->getOrderService()
            ->getCustomerOrderByUserId($orderId, $userId);
        
        return [
            'order' => $order,
            'result' => $result
        ];
    }
    
    /**
     * @return PaypalService
     */
    public function getPaypalService()
    {
        if (!$this->paypalService instanceof PaypalService) {
            $paypalService = $this->getServiceLocator()->get('Shop\Service\Paypal');
            $this->paypalService = $paypalService;
        }
        
        return $this->paypalService;
    }
    
    /**
     * @return OrderService
     */
    public function getOrderService()
    {
    	if (!$this->orderService instanceof OrderService) {
    		$orderService = $this->getServiceLocator()->get('Shop\Service\Order');
    		$this->orderService = $orderService;
    	}
    
    	return $this->orderService;
    }
}
