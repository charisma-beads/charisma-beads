<?php
namespace Shop\Hydrator\Product;

use UthandoCommon\Hydrator\AbstractHydrator;

class Option extends AbstractHydrator
{
	/**
	 * @param \Shop\Model\Product\Option $object
	 * @return array $data
	 */
	public function extract($object)
	{
		return array(
			'productOptionId'	=> $object->getProductOptionId(),
			'productId'			=> $object->getProductId(),
			'option'			=> $object->getOption(),
			'price'				=> $object->getPrice()
		);
	}
}
