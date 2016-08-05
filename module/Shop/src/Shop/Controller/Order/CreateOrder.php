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

use Shop\Service\Customer\Customer;
use Shop\ShopException;
use UthandoCommon\Service\ServiceTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class CreateOrder
 *
 * @package Shop\Controller\Order
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
        $customerId = $this->params()->fromRoute('customerId', null);

        if (null === $customerId) {
            throw new ShopException('No customer id was supplied');
        }

        /* @var Customer $service */
        $service = $this->getService('ShopCustomer');

        $customer = $service->getCustomerDetailsByCustomerId($customerId);

        if (null === $customer->getCustomerId()) {
            $this->redirect()->toRoute('admin/shop/customer/edit', [
                'action' => 'add',
            ]);
        }

        $order = $this->getService()->create($customer, [
            'collect_instore'   => false,
            'payment_option'    => 'pay_pending',
            'requirements'      => '',
        ]);

        $form = $this->getService()->prepareForm($order);

        return [
            'model' => $customer,
            'order' => $order,
            'form'  => $form,
        ];
    }

    public function addLineAction()
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
            //throw new ShopException('Access denied.');
        }

        $id = $this->params()->fromPost('productId', 0);
        $qty = $this->params()->fromPost('qty', 0);
        $product = $this->getService('ShopProduct')->getFullProductById($id);

        $viewModel = new ViewModel([
            'product' => $product,
            'quantity' => $qty,
        ]);

        $viewModel->setTerminal(true);

        return $viewModel;
    }

    public function saveAction()
    {

    }
}