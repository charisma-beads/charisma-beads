<?php
namespace Shop\Service;

use UthandoCommon\Service\AbstractService;
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
		
		$products = $this->getMapper()->getProductsByCategory($categoryId, $order);
		
		foreach ($products as $product) {
		    $product = $this->populate($product, true);
		}
	
		return $products;
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
	    
	    $products = $this->getMapper()->searchProducts($search);
	    
	    foreach ($products as $product) {
	        $this->populate($product, true);
	    }
	    
	    return $products;
	}

    /**
     * @param ProductModel $model
     * @param bool|array $children
     * @return \Shop\Model\Product|\UthandoCommon\Service\AbstractModel
     */
	public function populate($model, $children = false)
	{
		$allChildren = ($children === true) ? true : false;
		$children = (is_array($children)) ? $children : array();
		 
		if ($allChildren || in_array('category', $children)) {
			$model->setProductCategory(
			    $this->getCategoryService()
                    ->getById($model->getProductCategoryId())
		  );
		}
		 
		if ($allChildren || in_array('size', $children)) {
			$model->setProductSize(
			    $this->getSizeService()
                    ->getById($model->getProductSizeId())
		    );
		}
		 
		if ($allChildren || in_array('taxCode', $children)) {
			$model->setTaxCode(
			    $this->getTaxCodeService()
                    ->getById($model->getTaxCodeId())
            );
		}
		 
		if ($allChildren || in_array('postUnit', $children)) {
			$model->setPostUnit(
			    $this->getPostUnitService()
                    ->getById($model->getPostUnitId())
            );
		}
		 
		if ($allChildren || in_array('group', $children)) {
		    $id = $model->getProductGroupId();
		    if ($id) {
		        $model->setProductGroup(
		            $this->getGroupPriceService()->getById($id)
                );
		    } else {
		        $model->setProductGroup(
		            $this->getGroupPriceService()->getMapper()->getModel()
		        );
		    }
		}
		 
		if ($allChildren || in_array('image', $children)) {
			 
		}
		
		return $model;
	}
	
	public function toggleEnabled(ProductModel $product)
	{
		$enabled = (true === $product->getEnabled()) ? 0 : 1;
		
		$form  = $this->getForm($product, ['enabled' => $enabled], true, true);
		$form->setValidationGroup('enabled');
	
		return parent::edit($product, [], $form);
	}
	
	/**
	 * @return \Shop\Service\Product\Category
	 */
	public function getCategoryService()
	{
		if (!$this->categoryService) {
			$sl = $this->getServiceLocator();
			$this->categoryService = $sl->get('Shop\Service\Product\Category');
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
			$this->sizeService = $sl->get('Shop\Service\Product\Size');
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
			$this->taxCodeService = $sl->get('Shop\Service\Tax\Code');
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
			$this->postUnitService = $sl->get('Shop\Service\Post\Unit');
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
			$this->groupPriceService = $sl->get('Shop\Service\ProductGroup\Price');
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
			$this->imageService = $sl->get('\Service\Product\Image');
		}
	
		return $this->imageService;
	}
}
