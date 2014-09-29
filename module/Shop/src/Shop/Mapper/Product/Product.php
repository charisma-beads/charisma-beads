<?php
namespace Shop\Mapper\Product;

use UthandoCommon\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Select;

class Product extends AbstractDbMapper
{       
	protected $table = 'product';
	protected $primary = 'productId';
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
	    $select = $this->getSelect();
	    $select->where
	       ->equalTo('product.productId', $id);

        $select = $this->setFilter($select);
	    
	    $resultSet = $this->fetchResult($select);
	    $row = $resultSet->current();
	    return $row;
	}
	
	public function getProductsByCategory(array $categoryId, $order=null)
	{
	    $select = $this->getSelect();
		$select->where
            ->in('productCategoryId', $categoryId);

        $select = $this->setFilter($select);
		
		if ($order) {
		    $select = $this->setSortOrder($select, $order);
		}
		
		return $this->fetchResult($select);
	}
	
	public function search(array $search, $sort, Select $select = null)
	{
		$select = $this->getSql()->select();
		$select->from($this->table)
            ->join(
                'productCategory',
                'product.productCategoryId=productCategory.productCategoryId',
                array(),
                Select::JOIN_LEFT
            )
            ->join(
                'productGroup',
                'product.productGroupId=productGroup.productGroupId',
                array(),
                Select::JOIN_LEFT
            );
		
		$select = $this->setFilter($select);
		
		return parent::search($search, $sort, $select);
	}
	
	public function searchProducts(array $search)
	{
        $select = $this->getSql()->select();
        $select->from($this->table)
            ->join(
                'productCategory',
                'product.productCategoryId=productCategory.productCategoryId',
                array(),
                Select::JOIN_LEFT
            )->join(
                'postUnit',
                'product.postUnitId=postUnit.postUnitId',
                array(),
                Select::JOIN_LEFT
            )->join(
                'productSize',
                'product.productSizeId=productSize.productSizeId',
                array(),
                Select::JOIN_LEFT
            );

        $select = $this->setFilter($select);
	   
	   return parent::search($search, '', $select);
	}

    public function setFilter(Select $select)
    {
        if ($this->getFetchEnabled()) {
            $select->where->equalTo('product.enabled', 1);
        }

        if ($this->getFetchDisabled()) {
            $select->where->equalTo('product.discontinued', 1);
        } else {
            $select->where->equalTo('product.discontinued', 0);
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
