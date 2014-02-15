<?php
namespace Shop\Controller;

use Shop\ShopException;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class Catalog extends AbstractActionController
{
    /**
	 * @var \Shop\Service\Product
	 */
	protected $productService;
	
	/**
	 * @var \Shop\Service\ProductCategory
	 */
	protected $productCategoryService;
	
	/**
	 * @var \Shop\Options\ShopOptions;
	 */
	protected $shopOptions;
	
	public function indexAction()
	{
		$ident = $this->params('categoryIdent', 0);
		$page = $this->params('page', 1);
		
		$products = $this->getProductService()->usePaginator(array(
		    'limit' => $this->getShopOptions()->getProductsPerPage(),
		    'page'  => $page
		))->getProductsByCategory($ident);
	
		$category = $this->getProductCategoryService()->getCategoryByIdent(
			$this->params('categoryIdent', '')
		);
	
		if (null === $category) {
			throw new ShopException(
				'Unknown category ' . $this->params('categoryIdent')
			);
		}
	
		return new ViewModel(array(
			'bread'			=> $this->getBreadcrumb($category->getProductCategoryId()),
			'category'      => $category,
			'products'      => $products
		));
	}
	
	public function viewAction()
	{
		$product = $this->getProductService()->getProductByIdent(
			$this->params('productIdent', 0)
		);
	
		if (null === $product) {
			throw new ShopException('Unknown product' . $this->params('productIdent'));
		}
	
		$category = $this->getProductCategoryService()->getCategoryByIdent(
			$this->params('categoryIdent', '')
		);
		
		$view = new ViewModel(array(
			'product' => $product,
		));
	
		$view->headTitle(ucfirst($category->getName()))
			->headTitle(ucfirst($product->getName()));
	
		return $view;
	}
	
	public function searchAction()
	{
	    $page = $this->params()->fromPost('page', 1);
	    
	    $form = $this->getServiceLocator()->get('Shop\Form\CatalogSearch');
	    $form->setInputFilter($this->getServiceLocator()->get('Shop\InputFilter\CatalogSearch'));
	    $form->setData($this->params()->fromPost());
	    $form->isValid();
	    
	    $products = $this->getProductService()->usePaginator(array(
	        'limit' => $this->getShopOptions()->getProductsPerPage(),
	        'page'  => $page
	    ))->searchProducts($form->getData());
	    
	    $viewModel = new ViewModel(array(
	        'products' => $products
	    ));
	    
	    if ($this->getRequest()->isXmlHttpRequest()) {
	        $viewModel->setTerminal(true);
	    }
	    
	    return $viewModel;
	}
	
	public function getBreadcrumb($category)
	{
		return $this->getProductCategoryService()
			->getParentCategories($category);
	}
	
	/**
	 * @return \Shop\Options\ShopOptions;
	 */
	protected function getShopOptions()
	{
	    if (!$this->shopOptions) {
	    	$sl = $this->getServiceLocator();
	    	$this->shopOptions = $sl->get('Shop\Options\Shop');
	    }
	    
	    return $this->shopOptions;
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
	
	/**
	 * @return \Shop\Service\ProductCategory
	 */
	protected function getProductCategoryService()
	{
		if (!$this->productCategoryService) {
			$sl = $this->getServiceLocator();
			$this->productCategoryService = $sl->get('Shop\Service\ProductCategory');
		}
	
		return $this->productCategoryService;
	}
}
