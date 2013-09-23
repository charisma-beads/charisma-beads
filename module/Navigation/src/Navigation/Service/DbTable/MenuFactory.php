<?php
namespace Navigation\Service\DbTable;

use Application\Service\AbstractDbTableFactory;

class MenuFactory extends AbstractDbTableFactory
{

	protected function getName()
	{
		return 'Navigation\Model\DbTable\Menu';
	}
}