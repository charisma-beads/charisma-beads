<?php
namespace Shop\Service;

use Application\Service\AbstractService;

class Product extends AbstractService
{
	protected $mapperClass = 'Shop\Mapper\Product';
	protected $form = '';
	protected $inputFilter = '';
	
	/**
	 * @var \Shop\Service\Product\Category
	 */
	protected $categoryService;
	
	/**
	 * @var \Shop\Service\Product\GroupPrice
	 */
	protected $groupPriceService;
	
	public function getFullProductById($id)
	{
	    $id = (int) $id;
	    $this->getMapper()->useModelRelationships(true);
	    return $this->getMapper()->getFullProductById($id);
	}
	
	public function getProductByIdent($ident)
	{
		return $this->getMapper()->getProductByIdent($ident);
	}
	
	public function getProductsByCategory($category, $order=null, $deep=true)
	{
		if (is_string($category)) {
			$cat = $this->getCategoryService()->getCategoryByIdent($category);
			$categoryId = (null === $cat) ? 0 : $cat->getProductCategoryId();
		} else {
			$categoryId = (int) $category;
		}
	
		if (true === $deep) {
			$ids = $this->getCategoryService()->getCategoryChildrenIds(
				$categoryId, true
			);
	
			$ids[] = $categoryId;
			$categoryId = (null === $ids) ? $categoryId : $ids;
		}
		
		$this->getMapper()->useModelRelationships(true);
	
		return $this->getMapper()->getProductsByCategory($categoryId, $order);
	}
	
	public function searchProducts(array $post)
	{
	    $product = (isset($post['product'])) ? (string) $post['product'] : '';
	    $category = (isset($post['category'])) ? (string) $post['category'] : '';
	    $sort = (isset($post['sort'])) ? (string) $post['sort'] : '';
	    
	    //$this->getMapper()->useModelRelationships(true);
	    
	    $products = $this->getMapper()->searchProducts($product, $category, $sort);
	    
	    foreach ($products as $product) {
	        $this->populate($product);
	    }
	    
	    return $products;
	}
	
	/**
	 * 
	 * @param \Shop\Model\Product $product
	 */
	public function populate($product)
	{
	    $product->setRelationalModel($this->getCategoryService()->getById($product->getProductCategoryId()));
	    $product->setRelationalModel($this->getGroupPriceService()->getById($product->getProductGroupId()));
	}
	
	/**
	 * @return \Shop\Service\Product\GroupPrice
	 */
	public function getGroupPriceService()
	{
		if (!$this->groupPriceService) {
			$sl = $this->getServiceLocator();
			$this->groupPriceService = $sl->get('Shop\Service\ProductGroupPrice');
		}
	
		return $this->groupPriceService;
	}
	
	/**
	 * @return \Shop\Service\Product\Category
	 */
	public function getCategoryService()
	{
		if (!$this->categoryService) {
			$sl = $this->getServiceLocator();
			$this->categoryService = $sl->get('Shop\Service\ProductCategory');
		}
		
		return $this->categoryService;
	}
}
