<?php
namespace Shop\Mapper\Product;

use Application\Mapper\AbstractNestedSet;
use Shop\Model\Product\Category as CategoryModel;
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
	
	public function searchCategories($category, $sort)
	{
	    $select = $this->getFullTree();
	    
	    if (!$category == '') {
	    	if (substr($category, 0, 1) == '=') {
	    		$id = (int) substr($category, 1);
	    		$select->where->equalTo($this->getPrimaryKey(), $id);
	    	} else {
	    		$searchTerms = explode(' ', $category);
	    		$where = $select->where->nest();
	    
	    		foreach ($searchTerms as $value) {
	    			$where->like('child.category', '%'.$value.'%');
	    		}
	    
	    		$where->unnest();
	    	}
	    	
	    	if ($this->getFetchEnabled()) {
	    		$select->where->and->equalTo('child.enabled', 1);
	    	}
	    	
	    	if ($this->getFetchDisabled()) {
	    		$select->where->and->equalTo('child.discontinued', 1);
	    	} else {
	    		$select->where->and->equalTo('child.discontinued', 0);
	    	}
	    }
	    
	    if ($sort != '') {
	        $select->reset('order');
	        $select = $this->setSortOrder($select, $sort);
	    }
	    
	    
	    return $this->fetchResult($select);
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
