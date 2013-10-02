<?php
namespace Navigation\Mapper;

use Application\Mapper\AbstractMapper;

class Menu extends AbstractMapper
{
	protected $table = 'menu';
	protected $primary = 'menuId';
	protected $model = 'Navigation\Model\Menu';
	protected $hydrator = 'Navigation\Hydrator\Menu';
	
	public function getMenu($menu)
	{
	    $rowset = $this->getSelect()->where(array('menu' => $menu));
	    $row = $rowset->current();
	    return $row;
	}
}
