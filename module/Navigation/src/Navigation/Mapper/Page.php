<?php
namespace Navigation\Mapper;

use Application\Mapper\AbstractNestedSet;

class Page extends AbstractNestedSet
{
	protected $table = 'page';
	protected $primary = 'pageId';
	protected $model = 'Navigation\Model\Page';
	protected $hydrator = 'Navigation\Hydrator\Page';
    
    public function getPagesByMenuId($id)
    {   
        $select = $this->getFullTree();
        $select->reset('where');
        $select->where(array('child.menuId' => $id));
    	
    	return $this->fetchResult($select);
    }
    
    public function getPagesByMenu($menu)
    {
        $select = $this->getFullTree();
        $select->reset('where');
        $select->join(
        	'menu',
            'child.menuId = menu.menuId',
            array()
        )->where(array('menu.menu' => $menu));
        
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
