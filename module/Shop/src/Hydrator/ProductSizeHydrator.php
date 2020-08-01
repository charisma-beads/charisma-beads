<?php

namespace Shop\Hydrator;

use Common\Hydrator\AbstractHydrator;

/**
 * Class Size
 *
 * @package Shop\Hydrator
 */
class ProductSizeHydrator extends AbstractHydrator
{
	/**
	 * @param \Shop\Model\ProductSizeModel $object
	 * @return array $data
	 */
	public function extract($object)
	{
		return [
			'productSizeId'	=> $object->getProductSizeId(),
			'size'			=> $object->getSize()
        ];
	}
}
