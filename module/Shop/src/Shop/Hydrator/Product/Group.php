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
 * Class Group
 *
 * @package Shop\Hydrator\Product
 */
class Group extends AbstractHydrator
{
    /**
     * @param \Shop\Model\Product\Group $object
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
