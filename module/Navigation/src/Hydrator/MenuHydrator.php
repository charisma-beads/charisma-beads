<?php

namespace Navigation\Hydrator;

use Common\Hydrator\AbstractHydrator;


class MenuHydrator extends AbstractHydrator
{
	/**
	 * @param \Navigation\Model\MenuModel
	 * @return array
	 */
	public function extract($object)
	{
		return [
			'menuId'	=> $object->getMenuId(),
			'menu'		=> $object->getMenu()
		];
	}
}
