<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;
use Shop\Model\ProductStockStatus;

class ProductStockStatus extends AbstractHydrator
{
	public function extract(ProductStockStatus $object)
	{
		return array(
			'productStockStautsId'	=> $object->getProductStockStautsId(),
			'stockStatus'			=> $object->getStockStatus()
		);
	}
}
