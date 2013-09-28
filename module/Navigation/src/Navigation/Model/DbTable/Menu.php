<?php
namespace Navigation\Model\DbTable;

use Application\Model\DbTable\AbstractTable;

class Menu extends AbstractTable
{
	protected $table = 'menu';
	protected $primary = 'menuId';
	protected $rowClass = 'Navigation\Model\Entity\Menu';
	
	public function getMenu($menu)
	{
	    $rowset = $this->getTablegateway()->select(array('menu' => $menu));
	    $row = $rowset->current();
	    return $row;
	}
}
