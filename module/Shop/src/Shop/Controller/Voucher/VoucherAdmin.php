<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace Shop\Controller\Voucher;

use Shop\Form\Voucher\Voucher;
use Shop\Model\Order\Order;
use Shop\Model\Voucher\Code;
use Shop\Service\Customer\Customer;
use Shop\Service\Order\Order as OrderService;
use UthandoCommon\Controller\AbstractCrudController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 * Class VoucherAdmin
 *
 * @package Shop\Controller\Voucher
 */
class VoucherAdmin extends AbstractCrudController
{
    protected $controllerSearchOverrides = array('sort' => 'voucherId');
    protected $serviceName = 'ShopVoucherCode';
    protected $route = 'admin/shop/voucher';

    public function addVoucherAction()
    {
        $request = $this->getRequest();

        if (!$request->isXmlHttpRequest()) {
            throw new ShopException('Access denied.');
        }

        $order = $this->getOrder($this->params()->fromRoute('id', null));


        $form = $this->getService()->getForm(Voucher::class, [
            'order_model'   => $order,
            'customer'      => $order->getCustomer(),
        ]);

        $viewModel = new ViewModel([
            'form' => $form,
        ]);

        $viewModel->setTerminal(true);

        if ($request->isPost()) {
            $data = $this->params()->fromPost();

            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                $voucher = $this->getService()->getVoucherByCode($data['code']);

                $order->getMetadata()->setVoucher($voucher);

                /* @var OrderService $orderService */
                $orderService = $this->getService('ShopOrder');

                $orderService->save($order);

                return new JsonModel([
                    'success' => true,
                ]);
            }
        }

        return $viewModel;
    }

    public function setEnabledAction()
    {
        $id = (int)$this->params('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute($this->getRoute(), [
                'action' => 'list'
            ]);
        }

        try {
            /* @var $model Code */
            $model = $this->getService()->getById($id);
            $result = $this->getService()->toggleEnabled($model);
        } catch (Exception $e) {
            $this->setExceptionMessages($e);
            return $this->redirect()->toRoute($this->getRoute(), [
                'action' => 'list'
            ]);
        }

        return $this->redirect()->toRoute($this->getRoute(), [
            'action' => 'list'
        ]);
    }

    /**
     * @return null|Order
     */
    private function getOrder($orderId) : ?Order
    {
        /* @var OrderService $orderService */
        $orderService = $this->getService('ShopOrder');
        $order = $orderService->getOrder($orderId);
        return $order;
    }
}