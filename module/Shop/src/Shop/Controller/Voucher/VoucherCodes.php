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
use Shop\Model\Customer\Customer;
use Shop\Service\Cart\Cart;
use Shop\Service\Customer\Customer as CustomerService;
use Shop\ShopException;
use UthandoCommon\Service\ServiceTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class Code
 *
 * @package Shop\Controller\Voucher
 */
class VoucherCodes extends AbstractActionController
{
    use ServiceTrait;

    public function __construct()
    {
        $this->setServiceName('ShopVoucherCode');
    }

    public function addVoucherAction()
    {
        $request = $this->getRequest();

        if (!$request->isXmlHttpRequest()) {
            throw new ShopException('Access denied.');
        }

        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);

        $form = $this->getService()->getForm(Voucher::class, [
            'cart'      => $this->getCart()->getCart(),
            'customer'  => $this->getCustomer(),
        ]);
        $post = $this->params()->fromPost();

        $form->setData($post);

        if ($form->isValid()) {
            $this->getService()->storeVoucher($form->getData());
            $this->redirect()->toRoute('shop/cart/view');
        }

        return $viewModel->setVariable('form', $form);
    }

    private function getCart() : ?Cart
    {
        return $this->getService('ShopCart');
    }

    private function getCustomer() : ?Customer
    {
        if ($this->identity()) {
            $user = $this->identity();
            /* @var CustomerService $customerService */
            $customerService = $this->getService('ShopCustomer');
            $customer = $customerService->getCustomerByUserId($user->getUserId());

            return $customer;
        }

        return null;
    }
}