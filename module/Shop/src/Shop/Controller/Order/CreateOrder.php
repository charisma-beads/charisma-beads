<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Controller\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Controller\Order;

use Shop\Service\Order\Order;
use Shop\Service\Customer\Customer;
use Shop\ShopException;
use UthandoCommon\Service\ServiceTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class CreateOrder
 *
 * @package Shop\Controller\Order
 * @method Order getService($service = null, $options = [])
 */
class CreateOrder extends AbstractActionController
{
    use ServiceTrait;

    public function __construct()
    {
        $this->serviceName = 'ShopOrder';
    }

    public function addAction()
    {
        $prg        = $this->prg();
        $session    = $this->sessionContainer('createAdminOrder');
        $customerId = ($prg['customerId']) ?: $session->offsetGet('customerId');
        $orderId    = (isset($prg['customerId'])) ? null : $session->offsetGet('orderId');

        if (!$customerId && !$orderId) {
            throw new ShopException('No customer id, or order id was supplied');
        }

        /* @var Customer $service */
        $service    = $this->getService('ShopCustomer');
        $customer   = ($customerId) ? $service->getCustomerDetailsByCustomerId($customerId) : null;

        if (null === $customer->getCustomerId()) {
            $this->redirect()->toRoute('admin/shop/customer/edit', [
                'action' => 'add',
            ]);
        }

        $orderId = ($orderId) ?: $this->getService()->create($customer, [
            'collect_instore'   => false,
            'payment_option'    => 'pay_pending',
            'requirements'      => '',
        ]);

        if (!$orderId) {
            throw new ShopException('Something went wrong, order was not created.');
        }

        $session->offsetSet('orderId', $orderId);
        $session->offsetSet('customerId', $customerId);

        $order  = $this->getService()->getOrder($orderId);

        $this->getService()->loadItems($order);

        $form   = $this->getService()->prepareForm($order);

        return [
            'model' => $customer,
            'order' => $order,
            'form'  => $form,
        ];
    }

    /**
     * @return ViewModel
     * @throws ShopException
     */
    public function addLineAction()
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
            throw new ShopException('Access denied.');
        }

        $session    = $this->sessionContainer('createAdminOrder');
        $customerId = $session->offsetGet('customerId');

        $orderId    = $session->offsetGet('orderId');
        $order      = $this->getService()->getOrder($orderId);

        $productId  = $this->params()->fromPost('productId', 0);
        $product    = $this->getService('ShopProduct')->getFullProductById($productId);

        $this->getService()->loadItems($order);
        $this->getService()->addItem($product, $this->params()->fromPost());
        $this->getService()->recalculateTotals();
        $this->getService()->loadItems($this->getService()->getOrderModel());

        $viewModel = new ViewModel([
            'order' => $this->getService()->getOrderModel(),
        ]);

        $viewModel->setTerminal(true);

        return $viewModel;
    }

    public function saveAction()
    {

    }
}