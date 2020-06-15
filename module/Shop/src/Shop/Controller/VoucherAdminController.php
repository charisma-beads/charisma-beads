<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace Shop\Controller;

use Shop\Form\VoucherForm;
use Shop\Model\OrderModel;
use Shop\Model\VoucherCodeModel;
use Shop\Service\OrderService;
use Shop\Service\VoucherCodeService;
use Shop\ShopException;
use Common\Controller\AbstractCrudController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 * Class VoucherAdmin
 *
 * @package Shop\Controller
 */
class VoucherAdminController extends AbstractCrudController
{
    protected $controllerSearchOverrides = array('sort' => 'voucherId');
    protected $serviceName = VoucherCodeService::class;
    protected $route = 'admin/shop/voucher';

    public function addVoucherAction()
    {
        $request = $this->getRequest();

        if (!$request->isXmlHttpRequest()) {
            throw new ShopException('Access denied.');
        }

        $order = $this->getOrder($this->params()->fromRoute('id', null));


        $form = $this->getService()->getForm(VoucherForm::class, [
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
                $orderService = $this->getService(OrderService::class);

                $orderService->save($order);

                return new JsonModel([
                    'success' => true,
                    'discount' => $order->getDiscount(),
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
            /* @var $model VoucherCodeModel */
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
     * @param $orderId
     * @return null|OrderModel
     * @throws \Common\Model\CollectionException
     * @throws \Common\Service\ServiceException
     */
    private function getOrder($orderId) : ?OrderModel
    {
        /* @var OrderService $orderService */
        $orderService = $this->getService(OrderService::class);
        $order = $orderService->getOrder($orderId);
        return $order;
    }
}