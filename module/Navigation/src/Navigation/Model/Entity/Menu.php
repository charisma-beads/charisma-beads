<?php

namespace Navigation\Model\Entity;

use Application\Model\Entity\AbstractEntity;

class Menu extends AbstractEntity
{
	/**
	 * @var int
	 */
	protected $menuId;
	
	/**
	 * @var string
	 */
	protected $menu;
	
	protected $inputFilterClass = 'Navigation\InputFilter\Menu';
	
	public function exchangeArray(array $data)
	{
		$this->setMenuId($data['menuId'])
			->setMenu($data['menu']);
	}
	
	public function getArrayCopy()
	{
		return array(
			'menuId'	=> $this->getMenuId(),
			'menu'		=> $this->getMenu()
		);
	}
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
