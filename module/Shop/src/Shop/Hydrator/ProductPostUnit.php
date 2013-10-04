<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;

class ProductPostUnit extends AbstractHydrator
{
	/**
	 * @param \Shop\Model\ProductPostUnit $object
	 * @return array $data
	 */
	public function extract($object)
	{
		return array(
			'productPostUnitId'	=> $object->getProductPostUnitId(),
			'postUnit'			=> $object->getPostUnit()
		);
	}
}
