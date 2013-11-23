<?php
namespace Shop\Controller;

use Application\Controller\AbstractController;
use Shop\ShopException;
use Zend\View\Model\ViewModel;

class CatalogController extends AbstractController
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
		
		$products = $this->getProductService()->getProductsByCategory(
			$ident,
			$page,
		    $this->getShopOptions()->getProductsPerPage()
		);
	
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
	
		//$this->getBreadcrumb($category);
		
		$view = new ViewModel(array(
			'product' => $product,
		));
	
		$view->headTitle(ucfirst($category->getName()))
			->headTitle(ucfirst($product->getName()));
	
		return $view;
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
