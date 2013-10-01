<?php
namespace Shop\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Exception;
use FB;

class CatalogController extends AbstractController
{
	/**
	 * @var \Shop\Model\Catalog
	 */
	protected $catalogMapper;
	
	public function indexAction()
	{
		$ident = $this->params('categoryIdent', 0);
		$page = $this->params('page', 1);
		
		$products = $this->getCatalogMapper()->getProductsByCategory(
			$ident,
			$page
		);
	
		$category = $this->getCatalogMapper()->getCategoryByIdent(
			$this->params('categoryIdent', '')
		);
	
		if (null === $category) {
			throw new Exception(
				'Unknown category ' . $this->params('categoryIdent')
			);
		}
	
		return new ViewModel(array(
			'bread'			=> $this->getBreadcrumb($category->productCategoryId),
			'category'      => $category,
			'products'      => $products
		));
	}
	
	public function viewAction()
	{
		$product = $this->getCatalogMapper()->getProductByIdent(
			$this->params('productIdent', 0)
		);
	
		if (null === $product) {
			throw new Exception('Unknown product' . $this->params('productIdent'));
		}
	
		$category = $this->getCatalogMapper()->getCategoryByIdent(
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
		return $this->getCatalogMapper()
			->getParentCategories($category);
	}
	
	/**
	 * @return \Shop\Model\Catalog
	 */
	protected function getCatalogMapper()
	{
		if (!$this->catalogMapper) {
			$sl = $this->getServiceLocator();
			$this->catalogMapper = $sl->get('Shop\Service\Catalog');
		}
		
		return $this->catalogMapper;
	}
}
