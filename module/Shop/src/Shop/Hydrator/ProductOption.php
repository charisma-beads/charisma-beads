<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;
use Shop\Model\ProductOption;

class ProductOption extends AbstractHydrator
{
	public function extract(ProductOption $object)
	{
		return array(
			'productOptionId'	=> $object->getProductOptionId(),
			'productId'			=> $object->getProductId(),
			'option'			=> $object->getOption(),
			'price'				=> $object->getPrice()
		);
	}
}
