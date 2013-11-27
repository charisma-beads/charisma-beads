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
	    $page = $this->params()->fromRoute('page');
	    
	    $params = array(
	    	'sort' => 'name',
	    	'count' => 25,
	    	'page' => ($page) ? $page : 1
	    );
	    
	    return new ViewModel(array(
	    	'products' => $this->getPorductService()->fetchAllProducts($params)
	    ));
	}
	
	public function listAction()
	{
	    $params = $this->params()->fromPost();
	    
	    $viewModel = new ViewModel(array(
	    	'products' => $this->getPorductService()->fetchAllProducts($params)
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
	
	/**
	 * @return \Shop\Service\Product
	 */
	protected function getPorductService()
	{
		if (!$this->productService) {
		    $sl = $this->getServiceLocator();
			$this->productService = $sl->get('Shop\Service\Product');
		}
	
		return $this->productService;
	}
}
