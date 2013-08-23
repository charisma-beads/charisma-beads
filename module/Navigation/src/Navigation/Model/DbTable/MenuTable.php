<?php
namespace Navigation\Model\DbTable;

use Application\Model\DbTable\AbstractTable;

class MenuTable extends AbstractTable
{
	protected $table = 'menu';
	protected $primary = 'menuId';
	protected $rowClass = 'Core\Model\Entity\MenuEntity';
	
	public function getMenu($menu)
	{
	    $rowset = $this->tableGateway->select(array('menu' => $menu));
	    $row = $rowset->current();
	    return $row;
	}
}
