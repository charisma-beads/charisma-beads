<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Hydrator;

use UthandoCommon\Hydrator\AbstractHydrator;

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
