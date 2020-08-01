<?php

namespace Shop\Controller;

use Exception;
use Shop\Model\Product\ProductModel as ProductModel;
use Shop\Service\ProductService;
use Shop\ShopException;
use Common\Controller\AbstractCrudController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;

/**
 * Class Product
 *
 * @package Shop\Controller
 */
class ProductController extends AbstractCrudController
{
    protected $controllerSearchOverrides = [
        'sort'          => 'productId',
        'disabled'      => 0,
        'discontinued'  => 0,
    ];

    protected $serviceName = ProductService::class;

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
