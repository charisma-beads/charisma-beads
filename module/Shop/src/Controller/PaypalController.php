<?php

namespace Shop\Controller;

use Exception;
use PayPal\Exception\PayPalConnectionException;
use Shop\Service\PaymentException;
use Shop\Service\PaypalService;
use Shop\Service\OrderService;
use Common\Controller\SetExceptionMessages;
use Common\Service\ServiceTrait;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

/**
 * Class Paypal
 *
 * @package Shop\Controller
 */
class PaypalController extends AbstractActionController
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
    protected $orderService;

    public function searchAction()
    {
        $orderId    = $this->params()->fromRoute('paymentId');
        $error      = null;
        $payment    = null;
        $data       = null;
        $code       = null;

        try {
            $payment = $this->getPaypalService()
                ->getPayment($orderId);
        } catch (PayPalConnectionException $e) {
            $code = $e->getCode(); // Prints the Error Code
            $data = $e->getData(); // Prints the detailed error message
            $error = $e->getMessage();
        }

        $viewModel = new ViewModel([
            'payment'   => $payment,
            'error'     => $error,
            'data'      => $data,
            'code'      => $code,
        ]);

        if ($this->getRequest()->isXmlHttpRequest()) {
            $viewModel->setTerminal(true);
        }

        return $viewModel;
    }

    public function processAction()
    {
        $orderId = $this->params()->fromRoute('orderId');
        $userId = $this->identity()->getUserId();

        $order = $this->getOrderService()
            ->getCustomerOrderByUserId($orderId, $userId);

        try {
            $result = $this->getPaypalService()->createPayment($order);

            $update = $this->getOrderService()->save($result['order']);
        } catch (Exception $e) {

            $mailer = $this->getService('ExceptionMailer\ErrorHandling');
            $config = $mailer->getConfig();
            $config['exception_mailer']['template'] = 'error/paypal';
            $mailer->setConfig($config);

            $mailer->mailException($e);
            $this->setExceptionMessages($e);
            
            return ['order' => $order];
        }

        return $this->redirect()->toUrl($result['redirectUrl']);
    }

    /**
     * @return OrderService
     */
    public function getOrderService()
    {
        if (!$this->orderService instanceof OrderService) {
            $orderService = $this->getService(OrderService::class);
            $this->orderService = $orderService;
        }

        return $this->orderService;
    }

    /**
     * @return PaypalService
     */
    public function getPaypalService()
    {
        if (!$this->paypalService instanceof PaypalService) {
            $paypalService = $this->getService(PaypalService::class);
            $this->paypalService = $paypalService;
        }

        return $this->paypalService;
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

            $update = $this->getOrderService()->save($result);

            $order = (!$update) ?: $this->getOrderService()
                ->getCustomerOrderByUserId($orderId, $userId);

        } catch (Exception $e) {
            $mailer = $this->getService('ExceptionMailer\ErrorHandling');
            $config = $mailer->getConfig();
            $config['exception_mailer']['template'] = 'error/paypal';
            $mailer->setConfig($config);

            $mailer->mailException($e);
            $this->setExceptionMessages($e);
        }

        return [
            'order' => $order,
        ];
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
}
