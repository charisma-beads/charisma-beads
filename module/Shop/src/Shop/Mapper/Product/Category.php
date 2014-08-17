<?php
namespace Shop\Mapper\Product;

use UthandoCommon\Mapper\AbstractNestedSet;
use Shop\Model\Product\Category as CategoryModel;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;


class Category extends AbstractNestedSet
{
	protected $table = 'productCategory';
	protected $primary = 'productCategoryId';
	protected $model = 'Shop\Model\Product\Category';
	protected $hydrator = 'Shop\Hydrator\Product\Category';
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
		
		if ($this->getFetchEnabled()) {
			$select->where->and->equalTo('child.enabled', 1);
		}
		 
		if ($this->getFetchDisabled()) {
			$select->where->and->equalTo('child.discontinued', 1);
		} else {
			$select->where->and->equalTo('child.discontinued', 0);
		}
		 
		return $this->fetchResult($select);
	}
	
	public function getAllCategories()
	{
	    $select = $this->getFullTree();
	    
	    if ($this->getFetchEnabled()) {
	    	$select->where->and->equalTo('child.enabled', 1);
	    }
	    
	    if ($this->getFetchDisabled()) {
	    	$select->where->and->equalTo('child.discontinued', 1);
	    } else {
	    	$select->where->and->equalTo('child.discontinued', 0);
	    }
	    
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
	
	public function search(array $search, $sort, Select $select = null)
	{
	    $select = $this->getFullTree();
	    
	    if ($this->getFetchEnabled()) {
	    	$select->where->and->equalTo('child.enabled', 1);
	    }
	    
	    if ($this->getFetchDisabled()) {
	    	$select->where->and->equalTo('child.discontinued', 1);
	    } else {
	    	$select->where->and->equalTo('child.discontinued', 0);
	    }
	    
	    return parent::search($search, $sort, $select);
	}
	
	public function toggleEnabled(CategoryModel $model)
	{
		$data = $this->extract($model);
		
		$where = new Where();
		$where->between(self::COLUMN_LEFT, $data[self::COLUMN_LEFT], $data[self::COLUMN_RIGHT]);
		
		$data = array(
			'enabled'		=> $data['enabled'],
			'dateModified'	=> $data['dateModified']
		);
	
		return $this->update($data, $where);
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
