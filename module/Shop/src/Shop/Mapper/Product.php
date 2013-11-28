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
	protected $fetchEnabled = true;
	protected $fetchDisabled = false;
	
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
	       ->equalTo('product.productId', $id);
	    
	    $resultSet = $this->fetchResult($select);
	    $row = $resultSet->current();
	    return $row;
	}
	
	public function getProductsByCategory(array $categoryId, $page=null, $count=null, $order=null)
	{
	    $select = $this->getFullSelect();
		$where = $select->where
            ->in('product.productCategoryId', $categoryId);
		
		if ($order) {
		    $select = $this->setSortOrder($select, $order);
		}
		
		if (null === $page) {
	    	return $this->fetchResult($select);
	    } else {
	    	return $this->paginate($select, $page, $count);
	    }
	}
	
	public function fetchAllProducts(array $post)
	{
	    $count = (isset($post['count'])) ? (int) $post['count'] : null;
	    $product = (isset($post['product'])) ? (string) $post['product'] : '';
	    $category = (isset($post['category'])) ? (string) $post['category'] : '';
	    $sort = (isset($post['sort'])) ? (string) $post['sort'] : '';
	    $page = (isset($post['page'])) ? (int) $post['page'] : null;
	    
	    $select = $this->getFullSelect();
	    
	    if (!$product == '') {
	    	if (substr($product, 0, 1) == '=') {
	    		$id = (int) substr($product, 1);
	    		$select->where->equalTo('productId', $id);
	    	} else {
	    		$searchTerms = explode(' ', $product);
	    		$where = $select->where->nest();
	    		 
	    		foreach ($searchTerms as $value) {
	    			$where->like('name', '%'.$value.'%')
	    			->or
	    			->like('shortDescription',  '%'.$value.'%');
	    		}
	    		 
	    		$where->unnest();
	    	}
	    }
	    
	    if (!$category == '') {
	    	$select->where
	    	->nest()
	    	->like('category', '%'.$category.'%')
	    	->unnest();
	    }
	    
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
	    
	    if ($this->getFetchEnabled()) {
	    	$select->where->and->equalTo('product.enabled', 1);
	    }
	     
	    if ($this->getFetchDisabled()) {
	    	$select->where->and->equalTo('product.discontinued', 1);
	    } else {
	        $select->where->and->equalTo('product.discontinued', 0);
	    }
	    
	    return $select;
	}
	
	public function getFetchEnabled()
	{
		return $this->fetchEnabled;
	}

	public function setFetchEnabled($fetchEnabled)
	{
		$this->fetchEnabled = $fetchEnabled;
		return $this;
	}
	
	public function getFetchDisabled()
	{
		return $this->fetchDisabled;
	}

	public function setFetchDisabled($fetchDisabled)
	{
		$this->fetchDisabled = $fetchDisabled;
		return $this;
	}
}
