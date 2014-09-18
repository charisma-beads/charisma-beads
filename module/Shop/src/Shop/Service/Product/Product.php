<?php
namespace Shop\Service\Product;

use Shop\Model\Product\Product as ProductModel;
use UthandoCommon\Service\AbstractRelationalMapperService;

class Product extends AbstractRelationalMapperService
{
    protected $serviceAlias = 'ShopProduct';

    protected $referenceMap = [
        'productCategory'   => [
            'refCol'    => 'productCategoryId',
            'service'   => 'Shop\Service\Product\Category',
        ],
        'productSize'       => [
            'refCol'    => 'productSizeId',
            'service'   => 'Shop\Service\Product\Size',
        ],
        'taxCode'           => [
            'refCol'    => 'taxCodeId',
            'service'   => 'Shop\Service\Tax\Code',
        ],
        'postUnit'          => [
            'refCol'    => 'postUnitId',
            'service'   => 'Shop\Service\Post\Unit',
        ],
        'productGroup'      => [
            'refCol'    => 'productGroupId',
            'service'   => 'Shop\Service\Product\Group',
        ],
        'productImage'      => [
            'refCol'    => 'productId',
            'service'   => 'Shop\Service\Product\Image',
        ],
        'productOption' => [
            'refCol'    => 'productId',
            'service'   => 'Shop\Service\Product\Option',
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
        /* @var $mapper \Shop\Mapper\Product\Product */
        $mapper = $this->getMapper();
		return $mapper->getProductByIdent($ident);
	}
	
	public function getProductsByCategory($category, $order=null, $deep=true)
	{
        /* @var $mapper \Shop\Mapper\Product\Product */
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
	        $this->populate($product, [
                'productCategory',
                'productGroup',
            ]);
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

        /* @var $mapper \Shop\Mapper\Product\Product */
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
