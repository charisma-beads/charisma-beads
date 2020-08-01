<?php

namespace Navigation\Model;

use Common\Model\Model;
use Common\Model\ModelInterface;


class MenuModel implements ModelInterface
{
    use Model;
    
	/**
	 * @var int
	 */
	protected $menuId;
	
	/**
	 * @var string
	 */
	protected $menu;
	
	/**
	 * @return the $menuId
	 */
	public function getMenuId()
	{
		return $this->menuId;
	}

	/**
	 * @param number $menuId
	 */
	public function setMenuId($menuId)
	{
		$this->menuId = $menuId;
		return $this;
	}

	/**
	 * @return the $menu
	 */
	public function getMenu()
	{
		return $this->menu;
	}

	/**
	 * @param string $menu
	 */
	public function setMenu($menu)
	{
		$this->menu = $menu;
		return $this;
	}

}
