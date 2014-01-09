<?php
namespace Shop\Controller;

use Application\Controller\AbstractController;
use Shop\Form\Product as ProductForm;
use Zend\View\Model\ViewModel;

class ProductController extends AbstractController
{
	/**
	 * @var \Shop\Service\Product
	 */
	protected $productService;
	
	
	public function viewAction()
	{
		return new ViewModel();
	}
	
	public function indexAction()
	{
	    $page = $this->params()->fromRoute('page', 1);
	    
	    $params = array('sort' => 'name');
	    
	    $this->getProductService()->getMapper()->setFetchEnabled(false);
	    
	    return new ViewModel(array(
	    	'products' => $this->getProductService()->usePaginator(array(
	    	    'limit' => 25,
	    	    'page' => $page
            ))->searchProducts($params)
	    ));
	}
	
	public function listAction()
	{
	    if (!$this->getRequest()->isXmlHttpRequest()) {
	    	return $this->redirect()->toRoute('admin/shop/product');
	    }
	    
	    $params = $this->params()->fromPost();
	    
	    $this->getProductService()->getMapper()->setFetchEnabled(false);
	    
	    $viewModel = new ViewModel(array(
	    	'products' => $this->getProductService()->usePaginator(array(
	    	    'limit' => 25,
	    	    'page' => $params['page']
            ))->searchProducts($params)
	    ));
	    
	    $viewModel->setTerminal(true);
	    
	    return $viewModel;
	}
	
	public function setEnabledAction()
	{
	   $id = (int) $this->params('id', 0);
	   
		if (!$id) {
			return $this->redirect()->toRoute('admin/shop/product', array(
				'action' => 'list'
			));
		}

		// Get the Product with the specified id.  An exception is thrown
		// if it cannot be found, in which case go to the list page.
		try {
		    /* @var $product \Shop\Model\Product */
			$product = $this->getProductService()->getById($id);
		} catch (\Exception $e) {
		    $this->setExceptionMessages($e);
			return $this->redirect()->toRoute('admin/shop/product', array(
				'action' => 'list'
			));
		}
		
		if (true === $product->getEnabled()) {
		    $product->setEnabled(false);
		} else {
		    $product->setEnabled(true);
		}
		
		$result = $this->getProductService()->save($product);
		
		return $this->redirect()->toRoute('admin/shop/product', array(
			'action' => 'list'
		));
	}
	
	public function addAction()
	{
	    
	}
	
	public function editAction()
	{
		$id = (int) $this->params('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('admin/shop/product', array(
				'action' => 'add'
			));
		}
		
		// Get the Product with the specified id.  An exception is thrown
		// if it cannot be found, in which case go to the list page.
		try {
			$product = $this->getProductService()->getById($id);
		} catch (\Exception $e) {
			$this->setExceptionMessages($e);
			return $this->redirect()->toRoute('admin/shop/product', array(
				'action' => 'list'
			));
		}
		
		$request = $this->getRequest();
		
		if ($request->isPost()) {
				
			$result = $this->getProductService()->editProduct($product, $request->getPost());
		
			if ($result instanceof ProductForm) {
		
				$this->flashMessenger()->addInfoMessage(
					'There were one or more isues with your submission. Please correct them as indicated below.'
				);
		
				return new ViewModel(array(
					'form'		=> $result,
					'product'	=> $product,
				));
			} else {
				if ($result) {
					$this->flashMessenger()->addSuccessMessage(
						'Product has been saved to database.'
					);
				} else {
					$this->flashMessenger()->addErrorMessage(
						'Product could not be saved due to a database error.'
					);
				}
		
				// Redirect to list of articles
				return $this->redirect()->toRoute('admin/shop/product');
			}
		}
		
		$form = $this->getProductService()->getForm($product);
		
		return new ViewModel(array(
			'form'		=> $form,
			'product'	=> $product,
		));
	}
	
	public function deleteAction()
	{
	    
	}
	
	/**
	 * @return \Shop\Service\Product
	 */
	protected function getProductService()
	{
		if (!$this->productService) {
		    $sl = $this->getServiceLocator();
			$this->productService = $sl->get('Shop\Service\Product');
		}
	
		return $this->productService;
	}
}
