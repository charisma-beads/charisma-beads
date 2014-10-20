<?php
namespace Shop\Hydrator\Product;

use Shop\Hydrator\Strategy\Percent;
use UthandoCommon\Hydrator\AbstractHydrator;

class Option extends AbstractHydrator
{
    public function __construct()
    {
        parent::__construct();

        $this->addStrategy('discountPercent', new Percent());
    }
	/**
	 * @param \Shop\Model\Product\Option $object
	 * @return array $data
	 */
	public function extract($object)
	{
		return array(
			'productOptionId'	=> $object->getProductOptionId(),
			'productId'			=> $object->getProductId(),
            'postUnitId'        => $object->getPostUnitId(),
			'option'			=> $object->getOption(),
			'price'				=> $object->getPrice(false),
            'discountPercent'   => $this->extractValue('discountPercent', $object->getDiscountPercent()),
		);
	}
}
