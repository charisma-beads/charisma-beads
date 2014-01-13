<?php
namespace Shop\Controller;

use Application\Controller\AbstractController;
use Shop\Form\Product\Category as CategoryForm;
use Zend\View\Model\ViewModel;

class ProductCategoryController extends AbstractController
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
	    	    'limit' => $params['limit'],
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
    	$request = $this->getRequest();
    	
    	if ($request->isPost()) {
    	
    		$result = $this->getProductCategoryService()->addCategory($request->getPost());
    	
    		if ($result instanceof CategoryForm) {
    	
    			$this->flashMessenger()->addInfoMessage(
    				'There were one or more isues with your submission. Please correct them as indicated below.'
    			);
    	
    			return new ViewModel(array(
    				'form' => $result
    			));
    	
    		} else {
    			if ($result) {
    				$this->flashMessenger()->addSuccessMessage(
    					'Category has been saved to database.'
    				);
    			} else {
    				$this->flashMessenger()->addErrorMessage(
    					'Category could not be saved due to a database error.'
    				);
    			}
    	
    			// Redirect to list of categories
    			return $this->redirect()->toRoute('admin/shop/category');
    		}
    	}
    	
    	return new ViewModel(array(
    		'form' => $this->getProductCategoryService()->getForm(),
    	));
    }
    
    public function editAction()
    {
    	$id = (int) $this->params('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('admin/shop/category', array(
    			'action' => 'add'
    		));
    	}
    	
    	// Get the Product Category with the specified id.  An exception is thrown
    	// if it cannot be found, in which case go to the list page.
    	try {
    		$category = $this->getProductCategoryService()->getById($id);
    	} catch (\Exception $e) {
    		$this->setExceptionMessages($e);
    		return $this->redirect()->toRoute('admin/shop/category', array(
    			'action' => 'list'
    		));
    	}
    	
    	$request = $this->getRequest();
    	
    	if ($request->isPost()) {
    	
    		$result = $this->getProductCategoryService()->editCategory($category, $request->getPost());
    	
    		if ($result instanceof CategoryForm) {
    	
    			$this->flashMessenger()->addInfoMessage(
    				'There were one or more isues with your submission. Please correct them as indicated below.'
    			);
    	
    			return new ViewModel(array(
    				'form'		=> $result,
    				'category'	=> $category,
    			));
    		} else {
    			if ($result) {
    				$this->flashMessenger()->addSuccessMessage(
    					'Category has been saved to database.'
    				);
    			} else {
    				$this->flashMessenger()->addErrorMessage(
    					'Category could not be saved due to a database error.'
    				);
    			}
    	
    			// Redirect to list of categories
    			return $this->redirect()->toRoute('admin/shop/category');
    		}
    	}
    	
    	$form = $this->getProductCategoryService()->getForm($category);
    	
    	return new ViewModel(array(
    		'form'		=> $form,
    		'category'	=> $category,
    	));
    }
    
    public function deleteAction()
    {
    	$request = $this->getRequest();
    	
    	$id = (int) $request->getPost('productCategoryId');
    	if (!$id) {
    		return $this->redirect()->toRoute('admin/shop/category');
    	}
    	
    	if ($request->isPost()) {
    		$del = $request->getPost('submit', 'No');
    	
    		if ($del == 'delete') {
    			try {
    				$id = (int) $request->getPost('productCategoryId');
    				$result = $this->getProductCategoryService()->delete($id);
    					
    				if ($result) {
    					$this->flashMessenger()->addSuccessMessage(
    						'Category has been deleted from the database.'
    					);
    				} else {
    					$this->flashMessenger()->addErrorMessage(
    						'Category could not be deleted due to a database error.'
    					);
    				}
    			} catch (\Exception $e) {
    				$this->setExceptionMessages($e);
    			}
    		}
    	
    		// Redirect to list of categories
    		return $this->redirect()->toRoute('admin/shop/category');
    	}
    	
    	return $this->redirect()->toRoute('admin/shop/category');
    	 
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