<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractNestedSet;

class ProductCategory extends AbstractNestedSet
{
	protected $table = 'productCategory';
	protected $primary = 'productCategoryId';
	protected $model = 'Shop\Model\ProductCategory';
	protected $hydrator = 'Shop\Hydrator\ProductCategory';
	protected $fetchEnabled = true;
	protected $fetchDisabled = false;
	
	public function getCategoryByIdent($ident)
	{
		$ident = (string) $ident;
		$select = $this->getSelect()->where(array('ident' => $ident));
		$resultSet = $this->fetchResult($select);
		$row = $resultSet->current();
		return $row;
	}
	
	public function getTopLevelCategories()
	{
		$select = $this->getFullTree();
		$select->having('depth = 0');
		 
		return $this->fetchResult($select);
	}
	
	public function getAllCategories()
	{
	    $select = $this->getFullTree();
	    return $this->fetchResult($select);
	}
	
	public function getSubCategoriesByParentId($parentId, $immediate=true)
	{
	    $select = $this->getDecendentsByParentId($parentId, $immediate);
	    return $this->fetchResult($select);
	}
	
	public function getBreadCrumbs($id)
	{
	    $select = $this->getPathwayByChildId($id);
	    return $this->fetchResult($select);
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
