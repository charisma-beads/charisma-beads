<?php
namespace Shop\Service;

use Application\Model\ModelInterface;
use Application\Service\AbstractService;
use Shop\Model\Product as ProductModel;
use Shop\ShopException;
use Zend\Form\Form;

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
	
	public function search(array $post)
	{
	    $products = parent::search($post);
	    
	    foreach ($products as $product) {
	        $this->populate($product, true);
	    }
	    
	    return $products;
	}
	
	public function searchProducts(array $search)
	{
	    $search = array(array(
            'searchString'  => $search['productSearch'],
            'columns'       => array(
                'name', 'shortDescription', 'productCategory.category'
            ),
        ));
	    
	    $this->getMapper()->useModelRelationships(true);
	    
	    return $this->getMapper()->searchProducts($search);
	}
	
	/**
	 * @param ProductModel $model
	 * @param bool|array $children
	 */
	public function populate($model, $children = false)
	{
		$allChildren = ($children === true) ? true : false;
		$children = (is_array($children)) ? $children : array();
		 
		if ($allChildren || in_array('category', $children)) {
		    $id = $model->getProductCategoryId();
			$model->setRelationalModel($this->getCategoryService()->getById($id));
		}
		 
		if ($allChildren || in_array('size', $children)) {
			$model->setRelationalModel($this->getSizeService()->getById($model->getProductSizeId()));
		}
		 
		if ($allChildren || in_array('taxCode', $children)) {
			$model->setRelationalModel($this->getTaxCodeService()->getById($model->getTaxCodeId()));
		}
		 
		if ($allChildren || in_array('postUnit', $children)) {
			$model->setRelationalModel($this->getPostUnitService()->getById($model->getPostUnitId()));
		}
		 
		if ($allChildren || in_array('group', $children)) {
		    $id = $model->getProductGroupId();
		    if (0 !== $id) {
		        $model->setRelationalModel($this->getGroupPriceService()->getById($id));
		    }
		}
		 
		if ($allChildren || in_array('image', $children)) {
			 
		}
	}
	
	public function add(array $post)
	{
		if (!$post['ident']) {
			$post['ident'] = $post['name'] . ' ' . $post['shortDescription'];
		}
		
		return parent::add($post);
	}
	
	/**
	 * @param ProductModel $model
	 */
	public function edit(ModelInterface $model, array $post, Form $form = null)
	{
		if (!$model instanceof ProductModel) {
			throw new ShopException('$model must be an instance of Shop\Model\Product, ' . get_class($model) . ' given.');
		}
		
		if (!$post['ident']) {
			$post['ident'] = $post['name'] . ' ' . $post['shortDescription'];
		}
		
		$model->setDateModified();
		
		return parent::edit($model, $post);
	}
	
	public function toggleEnabled(ProductModel $product)
	{
	
		if (true === $product->getEnabled()) {
			$product->setEnabled(false);
		} else {
			$product->setEnabled(true);
		}
	
		$product->setDateModified();
	
		return $this->getMapper()->toggleEnabled($product);
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
