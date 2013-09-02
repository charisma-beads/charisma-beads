<?php
namespace Navigation\Model\DbTable;

use Application\Model\DbTable\AbstractNestedSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;

class PageTable extends AbstractNestedSet
{
	protected $table = 'page';
	protected $primary = 'pageId';
	protected $rowClass = 'Navigation\Model\Entity\PageEntity';
    
    public function getPagesByMenuId($id)
    {
    	$select = $this->sql->select();
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
        $select = $this->sql->select();
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
    	$rowSet = $this->tableGateway->select(array('menuId' => $menuId, 'label' => $label));
    	$row = $rowSet->current();
    	return $row;
    }
    
    public function deletePagesByMenuId($id)
    {
    	return $this->tableGateway->delete(array('menuId' => $id));
    }
}
