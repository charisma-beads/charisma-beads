<?php
namespace Shop\Service\DbTable;

use Application\Service\AbstractDbTableFactory;

class CategoryFactory extends AbstractDbTableFactory
{
	protected function getName()
	{
		return 'Shop\Model\DbTable\Product\Category';
	}
}
