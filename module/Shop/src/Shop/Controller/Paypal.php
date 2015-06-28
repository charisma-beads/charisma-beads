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

use Shop\Service\Payment\Paypal as PaypalService;
use Shop\Service\Order\Order as OrderService;
use UthandoCommon\Controller\SetExceptionMessages;
use Zend\Mvc\Controller\AbstractActionController;
use PayPal\Exception\PayPalConnectionException;
use UthandoCommon\Controller\ServiceTrait;

/**
 * Class Paypal
 *
 * @package Shop\Controller
 */
class Paypal extends AbstractActionController
{
    use SetExceptionMessages,
        ServiceTrait;
    
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
        $orderId = $this->params()->fromRoute('orderId');
        $userId = $this->identity()->getUserId();
        
        $order = $this->getOrderService()
            ->getCustomerOrderByUserId($orderId, $userId);
        
        try {
            $result = $this->getPaypalService()->createPayment($order);
            
            $update = $this->getOrderService()->save($result['order']);
        } catch (PayPalConnectionException $e) {
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
        catch (PayPalConnectionException $e) {
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

        $order = $this->getOrderService()
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
            $paypalService = $this->getService('ShopPaymentPaypal');
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
    		$orderService = $this->getService('ShopOrder');
    		$this->orderService = $orderService;
    	}
    
    	return $this->orderService;
    }
}
