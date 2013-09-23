<?php
namespace Navigation\Service\DbTable;

use Application\Service\AbstractDbTableFactory;

class PageFactory extends AbstractDbTableFactory
{

	protected function getName()
	{
		return 'Navigation\Model\DbTable\Page';
	}
}
