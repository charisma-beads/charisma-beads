<?php

namespace Shop\Controller;

use Shop\Form\Element\ProductCategoryImageList;
use Shop\Service\ProductCategoryService;
use Shop\ShopException;
use Common\Controller\AbstractCrudController;
use Laminas\View\Model\ViewModel;

/**
 * Class ProductCategory
 *
 * @package Shop\Controller
 */
class ProductCategoryController extends AbstractCrudController
{
    protected $controllerSearchOverrides = array('sort' => 'lft');
    protected $serviceName = ProductCategoryService::class;
    protected $route = 'admin/shop/category';

    /*protected $routes = [
        'edit' => 'admin/shop/category/edit',
    ];*/

    public function indexAction()
    {
        $this->getService()->getMapper()
            ->setFetchEnabled(false)
            ->setFetchDisabled(true);
        return parent::indexAction();
    }

    public function listAction()
    {
        $this->getService()->getMapper()
            ->setFetchEnabled(false)
            ->setFetchDisabled(true);
        return parent::listAction();
    }

    public function categoryImageSelectAction()
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
            throw new ShopException('Access denied');
        }

        $id = $this->params()->fromRoute('id', null);
        $selectElement = $this->getServiceLocator()
            ->get('FormElementManager')
            ->get(ProductCategoryImageList::class);

        $selectElement->setCategoryId($id);

        $viewModel = new ViewModel(['form' => $selectElement]);
        $viewModel->setTerminal(true);

        return $viewModel;
    }

    public function setEnabledAction()
    {
        $id = (int)$this->params('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute($this->getRoute(), array(
                'action' => 'list'
            ));
        }

        try {
            $category = $this->getService()->getById($id);
            $result = $this->getService()->toggleEnabled($category);
        } catch (\Exception $e) {
            $this->setExceptionMessages($e);
        }

        return $this->redirect()->toRoute($this->getRoute(), array(
            'action' => 'list'
        ));
    }
}