<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;
use Shop\Model\ProductPostUnit;

class ProductPostUnit extends AbstractHydrator
{
	public function extract(ProductPostUnit $object)
	{
		return array(
			'productPostUnitId'	=> $object->getProductPostUnitId(),
			'postUnit'			=> $object->getPostUnit()
		);
	}
}
