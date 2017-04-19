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

use Shop\Form\Voucher\VoucherFieldSet;
use Shop\ShopException;
use UthandoCommon\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;

/**
 * Class Code
 *
 * @package Shop\Controller\Voucher
 */
class VoucherCodes extends AbstractCrudController
{
    protected $controllerSearchOverrides = array('sort' => 'voucherId');
    protected $serviceName = 'ShopVoucherCode';
    protected $route = 'admin/shop/voucher';

    public function addVoucherAction()
    {
        $request = $this->getRequest();
        $session = $this->sessionContainer(VoucherCodes::class);

        if (!$request->isXmlHttpRequest()) {
            throw new ShopException('Access denied.');
        }

        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);

        $form = $this->getService()->getForm(VoucherFieldSet::class);
        $post = $this->params()->fromPost();

        $form->setData($post);

        if ($form->isValid()) {
            $this->getService()->storeVoucher($form);
            $this->redirect()->toRoute('shop/cart/view');
        }

        return $viewModel->setVariable('form', $form);
    }
}