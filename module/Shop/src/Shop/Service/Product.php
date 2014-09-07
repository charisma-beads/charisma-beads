<?php
namespace Shop\Service;

use Shop\Model\Product as ProductModel;
use UthandoCommon\Service\RelationalService;

class Product extends RelationalService
{
    protected $mapperClass  = 'Shop\Mapper\Product';
	protected $form         = 'Shop\Form\Product';
	protected $inputFilter  = 'Shop\InputFilter\Product';
    protected $referenceMap = [
        'productCategory'   => [
            'refCol'    => 'productCategoryId',
            'refClass'  => 'Shop\Service\Product\Category',
        ],
        'productSize'       => [
            'refCol'    => 'productSizeId',
            'refClass'  => 'Shop\Service\Product\Size',
        ],
        'taxCode'           => [
            'refCol'    => 'taxCodeId',
            'refClass'  => 'Shop\Service\Tax\Code',
        ],
        'postUnit'          => [
            'refCol'    => 'postUnitId',
            'refClass'  => 'Shop\Service\Post\Unit',
        ],
        'productGroup'      => [
            'refCol'    => 'productGroupId',
            'refClass'  => 'Shop\Service\Product\Group',
        ],
        'productImage'      => [
            'refCol'    => 'productId',
            'refClass'  => 'Shop\Service\Product\Image',
        ],
        'productOption' => [
            'refCol'    => 'productId',
            'refClass'  => 'Shop\Service\Product\Option',
        ],
    ];
	
	public function getFullProductById($id)
	{
	    $id = (int) $id;
	    $product = $this->getById($id);
	    
	    $this->populate($product, true);
	    
	    return $product;
	    
	}
	
	public function getProductByIdent($ident)
	{
        /* @var $mapper \Shop\Mapper\Product */
        $mapper = $this->getMapper();
		return $mapper->getProductByIdent($ident);
	}
	
	public function getProductsByCategory($category, $order=null, $deep=true)
	{
        /* @var $mapper \Shop\Mapper\Product */
        $mapper = $this->getMapper();

        /* @var $categoryService \Shop\Service\Product\Category */
        $categoryService = $this->getRelatedService('productCategory');

		if (is_string($category)) {
            /* @var $cat \Shop\Model\Product\Category */
            $cat = $categoryService->getCategoryByIdent($category);
			$categoryId = (null === $cat) ? 0 : $cat->getProductCategoryId();
		} else {
			$categoryId = (int) $category;
		}
	
		if (true === $deep) {
			$ids = $categoryService->getCategoryChildrenIds(
				$categoryId, true
			);
	
			$ids[] = $categoryId;
			$categoryId = (null === $ids) ? $categoryId : $ids;
		}
		
		$products = $mapper->getProductsByCategory($categoryId, $order);

        foreach ($products as $product) {
		     $this->populate($product, true);
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

        /* @var $mapper \Shop\Mapper\Product */
        $mapper = $this->getMapper();
	    
	    $products = $mapper->searchProducts($search);
	    
	    foreach ($products as $product) {
	        $this->populate($product, true);
	    }
	    
	    return $products;
	}
	
	public function toggleEnabled(ProductModel $product)
	{
		$enabled = (true === $product->getEnabled()) ? 0 : 1;
		
		$form  = $this->getForm($product, ['enabled' => $enabled], true, true);
		$form->setValidationGroup('enabled');
	
		return parent::edit($product, [], $form);
	}
}
