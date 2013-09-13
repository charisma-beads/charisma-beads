<?php
namespace Shop\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Exception;
use FB;

class CatalogController extends AbstractController
{
	public function indexAction()
	{
		$ident = $this->params('categoryIdent', 0);
		$page = $this->params('page', 1);
		
		$products = $this->getModel('Shop\Model\Catalog')->getProductsByCategory(
			$ident,
			$page
		);
	
		$category = $this->getModel('Shop\Model\Catalog')->getCategoryByIdent(
			$this->params('categoryIdent', '')
		);
		
		$subs = $this->getModel('Shop\Model\Catalog')->getCategoriesByParentId($category->productCategoryId);
		
		$breadCrumbs = $this->getBreadcrumb($category->productCategoryId);
	
		if (null === $category) {
			throw new Exception(
				'Unknown category ' . $this->params('categoryIdent')
			);
		}
	
		return new ViewModel(array(
			'breadCrumbs'	=> $breadCrumbs,
			'category'      => $category,
			'subCategories' => $subs,
			'products'      => $products
		));
	}
	
	public function viewAction()
	{
		$product = $this->getModel('Shop\Model\Catalog')->getProductByIdent(
			$this->params('productIdent', 0)
		);
	
		if (null === $product) {
			throw new Exception('Unknown product' . $this->params('productIdent'));
		}
	
		$category = $this->getModel('Shop\Model\Catalog')->getCategoryByIdent(
			$this->params('categoryIdent', '')
		);
	
		//$this->getBreadcrumb($category);
	
		//$this->view->headTitle(ucfirst($category->name))
			//->headTitle(ucfirst($product->name));
	
		return new ViewModel(array(
			'product' => $product,
		));
	}
	
	public function getBreadcrumb($category)
	{
		return $this->getModel('Shop\Model\Catalog')
			->getParentCategories($category);
	}
}
