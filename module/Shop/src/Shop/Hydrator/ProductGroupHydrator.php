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

use Common\Hydrator\AbstractHydrator;

/**
 * Class Group
 *
 * @package Shop\Hydrator
 */
class ProductGroupHydrator extends AbstractHydrator
{
    /**
     * @param \Shop\Model\ProductGroupModel $object
     * @return array
     */
    public function extract($object)
    {
        return [
        	'productGroupId'   => $object->getProductGroupId(),
            'group'            => $object->getGroup(),
            'price'            => $object->getPrice(),
        ];
    }
}
