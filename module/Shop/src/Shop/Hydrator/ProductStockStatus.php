<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;

class ProductStockStatus extends AbstractHydrator
{
	/**
	 * @param \Shop\Model\ProductStockStatus $object
	 * @return array $data
	 */
	public function extract($object)
	{
		return array(
			'productStockStautsId'	=> $object->getProductStockStautsId(),
			'stockStatus'			=> $object->getStockStatus()
		);
	}
}
