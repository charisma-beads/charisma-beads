<?php
namespace Shop\Hydrator\Product;

use Application\Hydrator\AbstractHydrator;

class Size extends AbstractHydrator
{
    protected $prefix = 'productSize.';
    
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
