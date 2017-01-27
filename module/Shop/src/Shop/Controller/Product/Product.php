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
use Zend\View\Model\JsonModel;
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

    public function getAction()
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
            throw new ShopException('Access denied.');
        }

        $id = $this->params()->fromRoute('id');
        $product = $this->getService()->getFullProductById($id);

        $viewModel = new ViewModel([
            'product' => $product,
        ]);
        $viewModel->setTerminal(true);

        return $viewModel;
    }

    public function searchAction()
    {
        $viewModel = new ViewModel();

        $query = htmlspecialchars_decode($this->params()->fromRoute('search'));

        if ($this->getRequest()->isXmlHttpRequest()) {
            $viewModel->setTerminal(true);
        }

        if ($query) {
            $this->getService()->setPopulate(false);

            $results = $this->getService()->search([
                'sort' => 'sku',
                'sku-shortDescription' => $query,
            ]);

            $viewModel = new JsonModel([
                'results' => $results->toArray()
            ]);
        }

        return $viewModel;
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
