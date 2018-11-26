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
use Shop\Model\CustomerModel;
use Shop\Service\CartService;
use Shop\Service\CountryService;
use Shop\Service\CustomerService;
use Shop\Service\VoucherCodeService;
use Shop\ShopException;
use UthandoCommon\Service\ServiceTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 * Class Code
 *
 * @package Shop\Controller
 * @method Container sessionContainer($sessionName = null)
 */
class VoucherCodesController extends AbstractActionController
{
    use ServiceTrait;

    public function __construct()
    {
        $this->setServiceName(VoucherCodeService::class);
    }

    public function addVoucherAction()
    {
        $request = $this->getRequest();

        if (!$request->isXmlHttpRequest()) {
            throw new ShopException('Access denied.');
        }

        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);
        $session = $this->sessionContainer(CartService::class);

        $form = $this->getService()->getForm(VoucherForm::class, [
            'order_model'   => $this->getCart()->getCart(),
            'customer'      => $this->getCustomer(),
        ]);

        if ($request->isPost()) {
            $post = $this->params()->fromPost();

            $form->setOption('country', $this->getService(CountryService::class)->getById($post['countryId']));

            $form->setData($post);

            if ($form->isValid()) {

                $data = $form->getData();

                $session->offsetSet('voucher', $data['code']);

                $this->flashMessenger()
                    ->addMessage(
                        'Your voucher code has been applied to your order.',
                        'voucher-success'
                    );

                return new JsonModel([
                    'success' => true,
                ]);
            } else {
                $this->flashMessenger()
                    ->addMessage(
                        'Your voucher code could not be applied to your order.',
                        'voucher-error'
                    );

                return new JsonModel([
                    'success' => false,
                ]);
            }
        }

        return $viewModel->setVariable('voucherForm', $form);
    }

    private function getCart() : ?CartService
    {
        return $this->getService(CartService::class);
    }

    private function getCustomer() : ?CustomerModel
    {
        if ($this->identity()) {
            $user = $this->identity();
            /* @var CustomerService $customerService */
            $customerService = $this->getService(CustomerService::class);
            $customer = $customerService->getCustomerByUserId($user->getUserId());

            return $customer;
        }

        return null;
    }
}