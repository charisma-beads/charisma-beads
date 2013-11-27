<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractMapper;
use Zend\Db\Sql\Select;

class Product extends AbstractMapper
{
	protected $table = 'product';
	protected $primary = 'productId';
	protected $model = 'Shop\Model\FullProduct';
	protected $hydrator = 'Shop\Hydrator\Product';
	
	public function getProductByIdent($ident)
	{
		$ident = (string) $ident;
		$select = $this->getSelect()->where(array('ident', $ident));
		$resultSet = $this->fetchResult($select);
		$row = $resultSet->current();
		return $row;
	}
	
	public function getFullProductById($id)
	{
	    $select = $this->getFullSelect();
	    $select->where
	       ->equalTo('product.productId', $id)
	       ->and->equalTo('product.enabled', 1)
	       ->and->equalTo('product.discontinued', 0);
	    
	    //$this->model = 'Shop\Model\FullProduct';
	    $resultSet = $this->fetchResult($select);
	    $row = $resultSet->current();
	    return $row;
	}
	
	public function getProductsByCategory(array $categoryId, $page=null, $count=null, $order=null)
	{
	    $select = $this->getFullSelect();
		$select->where
            ->in('product.productCategoryId', $categoryId)
            ->and->equalTo('product.enabled', 1)
            ->and->equalTo('product.discontinued', 0);
		
		$this->model = 'Shop\Model\FullProduct';
	
		if (true === is_array($order)) {
			$select = $this->setSortOrder($select, $order);
		}
	
		if (null !== $page) {
			return $this->paginate($select, $page, $count);
		}
	
		return $this->fetchResult($select);
	}
	
	public function fetchAllProducts(array $post)
	{
	    $count = (isset($post['count'])) ? (int) $post['count'] : null;
	    $product = (isset($post['product'])) ? (string) $post['product'] : '';
	    $category = (isset($post['category'])) ? (string) $post['category'] : '';
	    $sort = (isset($post['sort'])) ? (string) $post['sort'] : '';
	    $page = (isset($post['page'])) ? (int) $post['page'] : null;
	    
	    $select = $this->getFullSelect();
	    
	    $select = $this->setSortOrder($select, $sort);
	     
	    if (null === $page) {
	    	return $this->fetchResult($select);
	    } else {
	    	return $this->paginate($select, $page, $count);
	    }
	}
	
	/**
	 * @return \Zend\Db\Sql\Select
	 */
	public function getFullSelect()
	{
	    $select = $this->getSql()->select();
	    $select->from($this->table)
	    ->join(
	        'productCategory',
	        'product.productCategoryId=productCategory.productCategoryId',
	        array('category'),
	        Select::JOIN_INNER
        )->join(
	    	'productPostUnit',
	    	'product.productPostUnitId=productPostUnit.productPostUnitId',
	    	array('postUnit'),
	    	Select::JOIN_INNER
	    )->join(
	    	'productSize',
	    	'product.productSizeId=productSize.productSizeId',
	    	array('size'),
	    	Select::JOIN_INNER
	    )->join(
	    	'taxCode',
	    	'product.taxCodeId=taxCode.taxCodeId',
	    	array('taxCode'),
	    	Select::JOIN_INNER
	    )->join(
	    	'taxRate',
	    	'taxCode.taxRateId=taxRate.taxRateId',
	    	array('taxRate'),
	    	Select::JOIN_INNER
	    );
	    
	    return $select;
	}
}
