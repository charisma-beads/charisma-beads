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
        $page = $this->params()->fromRoute('page', 1);
	    
	    $params = array(
	    	'sort' => 'lft',
	    );
	    
	    $this->getProductCategoryService()->getMapper()->setFetchEnabled(false);
	    
	    return new ViewModel(array(
	    	'categories' => $this->getProductCategoryService()->usePaginator(array(
	    	    'limit' => 25,
	    	    'page' => $page
            ))->searchCategories($params)
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
        	'categories' => $this->getProductCategoryService()->usePaginator(array(
	    	    'limit' => 25,
	    	    'page' => $params['page']
            ))->searchCategories($params)
        ));
         
        $viewModel->setTerminal(true);
         
        return $viewModel;
    }
    
    public function setEnabledAction()
    {
    	$id = (int) $this->params('id', 0);
    
    	if (!$id) {
    		return $this->redirect()->toRoute('admin/shop/category', array(
    			'action' => 'list'
    		));
    	}
    
    	// Get the ProductCategory with the specified id.  An exception is thrown
    	// if it cannot be found, in which case go to the list page.
    	try {
    		/* @var $product \Shop\Model\ProductCategory */
    		$category = $this->getProductCategoryService()->getById($id);
    	} catch (\Exception $e) {
    		$this->setExceptionMessages($e);
    		return $this->redirect()->toRoute('admin/shop/product', array(
    			'action' => 'list'
    		));
    	}
    
    	if (true === $category->getEnabled()) {
    		$category->setEnabled(false);
    	} else {
    		$category->setEnabled(true);
    	}
    
    	$result = $this->getProductCategoryService()->save($category);
    
    	return $this->redirect()->toRoute('admin/shop/category', array(
    		'action' => 'list'
    	));
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