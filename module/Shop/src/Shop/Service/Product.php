<?php
namespace Shop\Service;

use Application\Service\AbstractService;
use Shop\Model\Product as ProductModel;

class Product extends AbstractService
{
	protected $mapperClass = 'Shop\Mapper\Product';
	protected $form = 'Shop\Form\Product';
	protected $inputFilter = 'Shop\InputFilter\Product';
	
	/**
	 * @var \Shop\Service\Product\Category
	 */
	protected $categoryService;
	
	/**
	 * @var \Shop\Service\Product\Size
	 */
	protected  $sizeService;
	
	/**
	 * @var \Shop\Service\Tax\Code
	 */
	protected  $taxCodeService;
	
	/**
	 * @var \Shop\Service\Post\Unit
	 */
	protected  $postUnitService;
	
	/**
	 * @var \Shop\Service\Product\GroupPrice
	 */
	protected $groupPriceService;
	
	/**
	 * @var \Shop\Service\Product\Image
	 */
	protected  $imageService;
	
	public function getFullProductById($id)
	{
	    $id = (int) $id;
	    $product = $this->getById($id);
	    
	    $this->populate($product, true);
	    
	    return $product;
	    
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
	        $this->populate($product, true);
	    }
	    
	    return $products;
	}
	
	/**
	 * @param \Shop\Model\Product $product
	 * @param bool|array $children
	 */
	public function populate(ProductModel $product, $children = false)
	{
		$allChildren = ($children === true) ? true : false;
		$children = (is_array($children)) ? $children : array();
		 
		if ($allChildren || in_array('category', $children)) {
		    $id = $product->getProductCategoryId();
			$product->setRelationalModel($this->getCategoryService()->getById($id));
		}
		 
		if ($allChildren || in_array('size', $children)) {
			$product->setRelationalModel($this->getSizeService()->getById($product->getProductSizeId()));
		}
		 
		if ($allChildren || in_array('taxCode', $children)) {
			$product->setRelationalModel($this->getTaxCodeService()->getById($product->getTaxCodeId()));
		}
		 
		if ($allChildren || in_array('postUnit', $children)) {
			$product->setRelationalModel($this->getPostUnitService()->getById($product->getPostUnitId()));
		}
		 
		if ($allChildren || in_array('group', $children)) {
		    $id = $product->getProductGroupId();
		    if (0 !== $id) {
		        $product->setRelationalModel($this->getGroupPriceService()->getById($id));
		    }
		}
		 
		if ($allChildren || in_array('image', $children)) {
			 
		}
	}
	
	public function editProduct(ProductModel $product, $post)
	{
		$product->setDateModified();
		return $this->edit($product, $post);
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
	
	/**
	 * @return \Shop\Service\Product\Size
	 */
	public function getSizeService()
	{
		if (!$this->sizeService) {
			$sl = $this->getServiceLocator();
			$this->sizeService = $sl->get('Shop\Service\ProductSize');
		}
	
		return $this->sizeService;
	}
	
	/**
	 * @return \Shop\Service\Tax\Code
	 */
	public function getTaxCodeService()
	{
		if (!$this->taxCodeService) {
			$sl = $this->getServiceLocator();
			$this->taxCodeService = $sl->get('Shop\Service\TaxCode');
		}
	
		return $this->taxCodeService;
	}
	
	/**
	 * @return \Shop\Service\Post\Unit
	 */
	public function getPostUnitService()
	{
		if (!$this->postUnitService) {
			$sl = $this->getServiceLocator();
			$this->postUnitService = $sl->get('Shop\Service\PostUnit');
		}
	
		return $this->postUnitService;
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
	 * @return \Shop\Service\Product\Image
	 */
	public function getImageService()
	{
		if (!$this->imageService) {
			$sl = $this->getServiceLocator();
			$this->imageService = $sl->get('Shop\Service\ProductImage');
		}
	
		return $this->imageService;
	}
}
