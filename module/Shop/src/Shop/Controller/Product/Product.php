<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Controller\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Controller\Product;

use Exception;
use Shop\Model\Product\Product as ProductModel;
use Shop\ShopException;
use UthandoCommon\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;

/**
 * Class Product
 *
 * @package Shop\Controller\Product
 */
class Product extends AbstractCrudController
{
    protected $controllerSearchOverrides = [
        'sort'          => 'productId',
        'disabled'      => 0,
        'discontinued'  => 0,
    ];

    protected $serviceName = 'ShopProduct';

    protected $route = 'admin/shop/product';

    protected $addRouteParams = true;

    protected $routes = [
        'edit' => 'admin/shop/product/edit',
    ];

    public function viewAction()
    {
        return new ViewModel();
    }

    public function duplicateAction()
    {
        $id = $this->params('id', 0);

        /* @var $product ProductModel */
        $product = $this->getService()->makeDuplicate($id);

        if (!$product instanceof ProductModel) {
            throw new ShopException('No product was found with id: ' . $id);
        }

        $form = $this->getService()->getForm($product);

        $viewModel = new ViewModel([
            'form' => $form,
            'routeParams' => $this->params()->fromRoute(),
        ]);

        $viewModel->setTemplate('shop/product/add');

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
            /* @var $product ProductModel */
            $product = $this->getService()->getById($id);
            $result = $this->getService()->toggleEnabled($product);
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
}
