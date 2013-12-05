<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractMapper;
use Zend\Db\Sql\Select;

class Product extends AbstractMapper
{
    const MODEL = 'Shop\Model\Product';
    const MODEL_RELATIONAL = 'Shop\Model\Relational\Product';
        
	protected $table = 'product';
	protected $primary = 'productId';
	protected $model = self::MODEL_RELATIONAL;
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
	
	public function getProductsByCategory(array $categoryId, $order=null)
	{
	    $select = $this->getFullSelect();
		$where = $select->where
            ->in('product.productCategoryId', $categoryId);
		
		if ($order) {
		    $select = $this->setSortOrder($select, $order);
		}
		
		return $this->fetchResult($select);
	}
	
	public function searchProducts($product, $category, $sort)
	{
	    $select = $this->getFullSelect();
	    
	    if (!$product == '') {
	    	if (substr($product, 0, 1) == '=') {
	    		$id = (int) substr($product, 1);
	    		$select->where->equalTo($this->primary, $id);
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
	     
	    return $this->fetchResult($select);
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
	    	'postUnit',
	    	'product.postUnitId=postUnit.postUnitId',
	    	array('postUnit'),
	    	Select::JOIN_INNER
	    )->join(
	    	'productSize',
	    	'product.productSizeId=productSize.productSizeId',
	    	array('size'),
	    	Select::JOIN_INNER
	    )->join(
	    	'productGroupPrice',
	    	'product.productGroupId=productGroupPrice.productGroupId',
	    	array('group'),
	    	Select::JOIN_LEFT
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
