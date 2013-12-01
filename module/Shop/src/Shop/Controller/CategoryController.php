<?php
namespace Shop\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class CategoryController extends AbstractController
{
    /**
     * @var \Shop\Service\ProductCategory
     */
    protected $productCategoryService;
    
    public function indexAction()
    {
        $page = $this->params()->fromRoute('page');
	    
	    $params = array(
	    	'sort' => 'lft',
	    	'count' => 25,
	    	'page' => ($page) ? $page : 1
	    );
	    
	    $this->getProductCategoryService()->getMapper()->setFetchEnabled(false);
	    
	    return new ViewModel(array(
	    	'products' => $this->getProductCategoryService()->fetchAllCategories($params)
	    ));
    }
    
    public function listAction()
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
        	return $this->redirect()->toRoute('admin/shop/category');
        }
         
        $params = $this->params()->fromPost();
         
        $this->getProductCategoryService()->getMapper()->setFetchEnabled(false);
         
        $viewModel = new ViewModel(array(
        	'categories' => $this->getProductCategoryService()->fetchAllCategories($params)
        ));
         
        $viewModel->setTerminal(true);
         
        return $viewModel;
    }
    
    public function addAction()
    {
        
    }
    
    public function editAction()
    {
        
    }
    
    public function deleteAction()
    {
        
    }
    
    public function changeCategoryStatusAction()
    {
        $id = (int) $this->params('id', 0);
        if (!$id) {
        	return $this->redirect()->toRoute('admin/shop/category', array(
        		'action' => 'list'
        	));
        }
        
        // Get the Product with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the list page.
        try {
        	/* @var $product \Shop\Model\Product */
        	$category = $this->getProductCategoryService()->getById($id);
        } catch (\Exception $e) {
        	$this->setExceptionMessages($e);
        	return $this->redirect()->toRoute('admin/shop/category', array(
        		'action' => 'list'
        	));
        }
        
        if (true === $category->getEnabled()) {
        	$category->setEnabled(false);
        } else {
        	$category->setEnabled(true);
        }
        
        $result = $this->getProductService()->save($category);
        
        return $this->redirect()->toRoute('admin/shop/category', array(
        	'action' => 'list'
        ));
    }
    
    /**
     * @return \Shop\Service\ProductCategory
     */
    protected function getProductCategoryService()
    {
        if (null === $this->productCategoryService) {
            $sl = $this->getServiceLocator();
            $this->productCategoryService = $sl->get('Shop\Service\ProductCategory');
        }
        
        return $this->productCategoryService;
    }
}