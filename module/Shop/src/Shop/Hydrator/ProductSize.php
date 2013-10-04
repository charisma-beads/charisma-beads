<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;

class ProductSize extends AbstractHydrator
{
	/**
	 * @param \Shop\Model\ProductSize $object
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
