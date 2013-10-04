<?php
namespace Navigation\Mapper;

use Application\Mapper\AbstractNestedSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;

class Page extends AbstractNestedSet
{
	protected $table = 'page';
	protected $primary = 'pageId';
	protected $model = 'Navigation\Model\Page';
	protected $hydrator = 'Navigation\Hydrator\Page';
    
    public function getPagesByMenuId($id)
    {
    	$select = $this->getSql()->select();
    	$select->from(array('child' => $this->table))
    	->columns(array(
    	    Select::SQL_STAR,
    	    'depth' => new Expression('(COUNT(parent.'.$this->primary.') - 1)')
    	))
    	->join(
    	    array('parent' => $this->table),
    	    'child.lft BETWEEN parent.lft AND parent.rgt',
    	    array(),
    	    Select::JOIN_INNER
    	)
    	->where(array('child.menuId' => $id))
    	->group('child.'.$this->primary)
    	->order('child.lft');
    	
    	return $this->fetchResult($select);
    }
    
    public function getPagesByMenu($menu)
    {
        $select = $this->getSql()->select();
        $select->from(array('child' => $this->table))
        ->columns(array(
            Select::SQL_STAR,
            'depth' => new Expression('(COUNT(parent.'.$this->primary.') - 1)')
        ))
        ->join(
            array('parent' => $this->table),
            'child.lft BETWEEN parent.lft AND parent.rgt',
            array(),
            Select::JOIN_INNER
        )
        ->join(
        	'menu',
            'child.menuId = menu.menuId',
            array()
        )
        ->where(array('menu.menu' => $menu))
        ->group('child.'.$this->primary)
        ->order('child.lft');
        
        return $this->fetchResult($select);
    }
    
    public function getPageByMenuIdAndLabel($menuId, $label)
    {
    	$select = $this->getSelect()->where(array('menuId' => $menuId, 'label' => $label));
    	$rowSet = $this->fetchResult($select);
    	$row = $rowSet->current();
    	return $row;
    }
    
    public function deletePagesByMenuId($id)
    {
    	$sql = $this->getSql();
    	$delete = $sql->delete($this->table);
    	
    	$delete->where(array('menuId' => $id));
    	
    	$statement = $sql->prepareStatementForSqlObject($delete);
    	
    	return $statement->execute();
    }
}
