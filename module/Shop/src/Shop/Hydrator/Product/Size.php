<?php
namespace Shop\Hydrator\Product;

use UthandoCommon\Hydrator\AbstractHydrator;

class Size extends AbstractHydrator
{
	/**
	 * @param \Shop\Model\Product\Size $object
	 * @return array $data
	 */
	public function extract($object)
	{
		return array(
			'productSizeId'	=> $object->getProductSizeId(),
			'size'			=> $object->getSize()
		);
	}
}
