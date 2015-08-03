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

use UthandoCommon\Hydrator\AbstractHydrator;

/**
 * Class Size
 *
 * @package Shop\Hydrator\Product
 */
class Size extends AbstractHydrator
{
	/**
	 * @param \Shop\Model\Product\Size $object
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
