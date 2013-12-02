<?php
namespace Shop\Controller;

use Application\Controller\AbstractController;
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
