<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Controller\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Controller;

use Shop\Service\OrderService;
use Shop\Service\CustomerService;
use Shop\Service\ProductService;
use Shop\ShopException;
use Common\Service\ServiceTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class CreateOrder
 *
 * @package Shop\Controller
 * @method OrderService getService($service = null, $options = [])
 */
class CreateOrderController extends AbstractActionController
{
    use ServiceTrait;

    public function __construct()
    {
        $this->serviceName = OrderService::class;
    }

    public function addAction()
    {
        //$prg        = $this->prg();
        //$session    = $this->sessionContainer('createAdminOrder');
        $customerId = $this->params()->fromPost('customerId', null);

        if (!$customerId) {
            throw new ShopException('No customer id was supplied');
        }

        /* @var CustomerService $service */
        $service    = $this->getService(CustomerService::class);
        $customer   = ($customerId) ? $service->getCustomerDetailsByCustomerId($customerId) : null;

        if (null === $customer->getCustomerId()) {
            $this->redirect()->toRoute('admin/shop/customer/edit', [
                'action' => 'add',
            ]);
        }

        $orderId = $this->getService()->create($customer, [
            'collect_instore'   => false,
            'payment_option'    => 'pay_pending',
            'requirements'      => '',
        ]);

        if (!$orderId) {
            throw new ShopException('Something went wrong, order was not created.');
        }

        //$session->offsetSet('orderId', $orderId);
        //$session->offsetSet('customerId', $customerId);

        $order  = $this->getService()->getOrder($orderId);

        //$this->getService()->loadItems($order);

        $form   = $this->getService()->prepareForm($order);

        return [
            'model' => $customer,
            'order' => $order,
            'form'  => $form,
        ];
    }

    public function editAction()
    {
        $orderId    = $this->params()->fromRoute('id', 0);

        $order      = $this->getService()->getOrder($orderId);

        /* @var CustomerService $service */
        $service    = $this->getService(CustomerService::class);
        $customer   = $service->getCustomerDetailsByCustomerId(
            $order->getMetadata()->getDeliveryAddress()->getCustomerId()
        );

        $form   = $this->getService()->prepareForm($order);
        $form->configureFormValues($order);

        $viewModel = new ViewModel([
            'model' => $customer,
            'order' => $order,
            'form'  => $form,
        ]);

        $viewModel->setTemplate('shop/create-order/add');

        return $viewModel;
    }

    public function saveAction()
    {
        $post = $this->params()->fromPost();
        $id = $this->params()->fromPost('orderId', null);

        if (!$id) {
            throw new ShopException('No order id was supplied');
        }

        $order = $this->getService()->getOrder($id);

        if ($id !== $order->getId()) {
            throw new ShopException('No order ids do not match');
        }

        $form = $this->getService()->prepareForm($order, $post, true, true);
        $hydrator = $form->getHydrator();
        $dateTimeStrategy = $hydrator->getStrategy('orderDate');
        $dateTimeStrategy->setHydrateFormat('d/m/Y H:i:s');

        if ($form->isValid()) {
            $data = $form->getData();
            $data->getMetadata()->setRequirements($post['requirements']);
            $paymentOption = ucwords(str_replace(
                '_',
                ' ',
                str_replace('pay_', '', $post['payment_option'])
            ));
            $data->getMetaData()->setPaymentMethod($paymentOption);
            $result = $this->getService()->save($data);

            if ($result) {
                $this->flashMessenger()->addSuccessMessage('row ' . $order->getId() . ' has been saved to database table orders');


            } else {
                $this->flashMessenger()->addInfoMessage('No changes were saved to row ' . $order->getId() . '.');
            }

            if ($post['email_order']) {
                $email = $this->getService()->sendEmail($order->getOrderId());

                if ($email instanceof \Exception) {
                    $this->flashMessenger()->addErrorMessage($email->getMessage());
                }
            }

            return $this->redirect()->toRoute('admin/shop/order');
        }

        /* @var CustomerService $service */
        $service    = $this->getService(CustomerService::class);
        $customer   = $service->getCustomerDetailsByCustomerId(
            $order->getMetadata()->getDeliveryAddress()->getCustomerId()
        );

        $viewModel = new ViewModel([
            'model' => $customer,
            'order' => $order,
            'form'  => $form,
        ]);

        $viewModel->setTemplate('shop/create-order/add');

        return $viewModel;
    }

    /**
     * @return ViewModel
     * @throws ShopException
     * @throws \Common\Model\CollectionException
     * @throws \Common\Service\ServiceException
     */
    public function addLineAction()
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
            throw new ShopException('Access denied.');
        }

        //$session    = $this->sessionContainer('createAdminOrder');
        //$orderId    = $session->offsetGet('orderId');

        $orderId    = $this->params()->fromPost('id', 0);
        $productId  = $this->params()->fromPost('productId', 0);
        $order      = $this->getService()->getOrder($orderId);
        $product    = $this->getService(ProductService::class)->getFullProductById($productId);

        //$this->getService()->loadItems($order);
        $this->getService()->addItem($product, $this->params()->fromPost());
        $this->getService()->calculateTotals();
        //$this->getService()->loadItems($this->getService()->getOrderModel());

        $viewModel = new ViewModel([
            'order' => $this->getService()->getOrder($orderId),
        ]);

        $viewModel->setTerminal(true);

        return $viewModel;
    }

    public function reloadAction()
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
            throw new ShopException('Access denied.');
        }

        //$session    = $this->sessionContainer('createAdminOrder');
        $orderId    = $this->params()->fromRoute('id', 0);


        $order  = $this->getService()->getOrder($orderId);
        //$order  = $this->getService()->loadItems($order);
        $this->getService()->calculateTotals();

        $viewModel = new ViewModel([
            'order' => $order,
        ]);

        $viewModel->setTemplate('shop/create-order/add-line');

        $viewModel->setTerminal(true);

        return $viewModel;
    }

    public function removeLineAction()
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
            throw new ShopException('Access denied.');
        }

        //$session    = $this->sessionContainer('createAdminOrder');
        $orderId    = $this->params()->fromRoute('id', 0);
        $lineId     = $this->params()->fromPost('lineId', 0);

        $this->getService()->removeItem($lineId);

        $order  = $this->getService()->getOrder($orderId);
        //$order  = $this->getService()->loadItems($order);
        $this->getService()->calculateTotals();

        $viewModel = new ViewModel([
            'order' => $order,
        ]);

        $viewModel->setTemplate('shop/create-order/add-line');

        $viewModel->setTerminal(true);

        return $viewModel;
    }

    public function instoreAction()
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
            throw new ShopException('Access denied.');
        }

        $orderId    = $this->params()->fromRoute('id', 0);
        $order      = $this->getService()->getOrder($orderId);

        if ($order->getMetadata()->getShippingMethod() == 'Collect at Open Day') {
            $order->getMetadata()->setShippingMethod('Royal Mail');
        } else {
            $order->getMetadata()->setShippingMethod('Collect at Open Day');
        }

        $this->getService()->save($order);

        //$order  = $this->getService()->loadItems($order);
        $this->getService()->calculateTotals();

        $viewModel = new ViewModel([
            'order' => $order,
        ]);

        $viewModel->setTemplate('shop/create-order/add-line');

        $viewModel->setTerminal(true);

        return $viewModel;
    }
}