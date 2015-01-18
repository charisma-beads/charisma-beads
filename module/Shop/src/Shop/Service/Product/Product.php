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
            'service'   => 'ShopProductCategory',
        ],
        'productSize'       => [
            'refCol'    => 'productSizeId',
            'service'   => 'ShopProductSize',
        ],
        'taxCode'           => [
            'refCol'    => 'taxCodeId',
            'service'   => 'ShopTaxCode',
        ],
        'postUnit'          => [
            'refCol'    => 'postUnitId',
            'service'   => 'ShopPostUnit',
        ],
        'productGroup'      => [
            'refCol'    => 'productGroupId',
            'service'   => 'ShopProductGroup',
        ],
        'productImage'      => [
            'refCol'    => 'productId',
            'service'   => 'ShopProductImage',
            //'getMethod' => 'getImagesByProductId',
        ],
        'productOption' => [
            'refCol'    => 'productId',
            'service'   => 'ShopProductOption',
            //'getMethod' => 'getOptionsByProductId',
        ],
    ];

    /**
     * @param int $id
     * @return array|mixed|\UthandoCommon\Model\ModelInterface|ProductModel
     */
	public function getFullProductById($id)
	{
	    $id = (int) $id;
	    $product = $this->getById($id);
	    
	    $this->populate($product, true);
	    
	    return $product;
	    
	}

    /**
     * @param string $ident
     * @return \Shop\Model\Product\Product
     */
	public function getProductByIdent($ident)
	{
        /* @var $mapper \Shop\Mapper\Product\Product */
        $mapper = $this->getMapper();
		$product = $mapper->getProductByIdent($ident);
        $this->populate($product, true);
        return $product;
	}

    /**
     * @param string|int $category
     * @param null $order
     * @param bool $deep
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     * @throws \UthandoCommon\Service\ServiceException
     */
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

    /**
     * @param array $search
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
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

    /**
     * Make a new product based on a product.
     *
     * @param int $id
     * @return ProductModel $product
     */
    public function makeDuplicate($id)
    {
        $product = $this->getFullProductById($id);

        $product->setProductId(null)
            ->setName(null)
            ->setIdent(null);

        return $product;
    }

    /**
     * @param ProductModel $product
     * @return int
     */
	public function toggleEnabled(ProductModel $product)
	{
		$enabled = (true === $product->getEnabled()) ? 0 : 1;
		
		$form  = $this->getForm($product, ['enabled' => $enabled], true, true);
		$form->setValidationGroup('enabled');
	
		return parent::edit($product, [], $form);
	}
}
