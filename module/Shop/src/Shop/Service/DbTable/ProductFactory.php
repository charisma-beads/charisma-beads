<?php
namespace Shop\Service\DbTable;

use Application\Service\AbstractDbTableFactory;

class ProductFactory extends AbstractDbTableFactory
{

	protected function getName()
	{
		return 'Shop\Model\DbTable\Product';
	}
}
