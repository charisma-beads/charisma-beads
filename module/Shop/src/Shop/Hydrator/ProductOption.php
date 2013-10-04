<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;

class ProductOption extends AbstractHydrator
{
	/**
	 * @param \Shop\Model\ProductOption $object
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
