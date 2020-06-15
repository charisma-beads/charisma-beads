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

use Shop\Hydrator\Strategy\PercentStrategy;
use Common\Hydrator\AbstractHydrator;

/**
 * Class Option
 *
 * @package Shop\Hydrator
 */
class ProductOptionHydrator extends AbstractHydrator
{
    public function __construct()
    {
        parent::__construct();

        $this->addStrategy('discountPercent', new PercentStrategy());
    }
	/**
	 * @param \Shop\Model\ProductOptionModel $object
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
