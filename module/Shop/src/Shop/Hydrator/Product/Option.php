<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Hydrator\Product;

use Shop\Hydrator\Strategy\Percent;
use UthandoCommon\Hydrator\AbstractHydrator;

/**
 * Class Option
 *
 * @package Shop\Hydrator\Product
 */
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
		return [
			'productOptionId'	=> $object->getProductOptionId(),
			'productId'			=> $object->getProductId(),
            'postUnitId'        => $object->getPostUnitId(),
			'option'			=> $object->getOption(),
			'price'				=> $object->getPrice(false),
            'discountPercent'   => $this->extractValue('discountPercent', $object->getDiscountPercent()),
        ];
	}
}
