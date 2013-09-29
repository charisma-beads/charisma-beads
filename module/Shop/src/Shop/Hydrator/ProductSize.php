<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;
use Shop\Model\ProductSize;

class ProductSize extends AbstractHydrator
{
	public function extract(ProductSize $object)
	{
		return array(
			'productSizeId'	=> $object->getProductSizeId(),
			'size'			=> $object->getSize()
		);
	}
}
