<?php
namespace Navigation\Hydrator;

use Application\Hydrator\AbstractHydrator;

class Menu extends AbstractHydrator
{
	/**
	 * @param \Navigation\Model\Menu
	 * @return array
	 */
	public function extract($object)
	{
		return array(
			'menuId'	=> $object->getMenuId(),
			'menu'		=> $object->getMenu()
		);
	}
}
