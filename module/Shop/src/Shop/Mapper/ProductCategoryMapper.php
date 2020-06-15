<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Mapper\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Mapper;

use Common\Mapper\AbstractNestedSet;
use Shop\Model\ProductCategoryModel as CategoryModel;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Select;

/**
 * Class Category
 *
 * @package Shop\Mapper
 */
class ProductCategoryMapper extends AbstractNestedSet
{
	protected $table = 'productCategory';
	protected $primary = 'productCategoryId';
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
		
		$select = $this->setFilter($select);
		 
		return $this->fetchResult($select);
	}
	
	public function getAllCategories()
	{
	    $select = $this->getFullTree();
	    
	    $select = $this->setFilter($select);
	    
	    return $this->fetchResult($select);
	}

    /**
     * @param $parentId
     * @param bool $immediate
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
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
	
	public function search(array $search, $sort, $select = null)
	{
	    $select = $this->getFullTree();
	    
	    $select = $this->setFilter($select);
	    
	    return parent::search($search, $sort, $select);
	}
	
	public function cascadeDiscontinued(array $ids, $value)
	{
	    $where = new Where();
	    $where->in('productCategoryId', $ids);
	     
	    $this->update(['discontinued' => $value], $where, 'product');
	}
	
	public function cascadeEnabled(array $ids, $value)
	{
	    $where = new Where();
	    $where->in('productCategoryId', $ids);
	    
	    $this->update(['enabled' => $value], $where, 'product');
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
	
	public function toggleDiscontinued(CategoryModel $model)
	{
	    $data = $this->extract($model);
	
	    $where = new Where();
	    $where->between(self::COLUMN_LEFT, $data[self::COLUMN_LEFT], $data[self::COLUMN_RIGHT]);
	
	    $data = array(
	        'discontinued'		=> $data['discontinued'],
	        'dateModified'	=> $data['dateModified']
	    );
	
	    return $this->update($data, $where);
	}
	
	public function setFilter(Select $select)
	{
	    if ($this->getFetchEnabled()) {
	        $select->where->equalTo('child.enabled', 1);
	    }
	
	    if (!$this->getFetchDisabled()) {
	        $select->where->equalTo('child.discontinued', 0);
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
