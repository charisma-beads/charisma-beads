<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator\Post
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Hydrator\Post;

use UthandoCommon\Hydrator\AbstractHydrator;

/**
 * Class Zone
 *
 * @package Shop\Hydrator\Post
 */
class Zone extends AbstractHydrator
{
    /**
     * @param \Shop\Model\Post\Zone $object
     * @return array $data
     */
    public function extract($object)
    {
        return [
        	'postZoneId'   => $object->getPostZoneId(),
            'taxCodeId'    => $object->getTaxCodeId(),
            'zone'         => $object->getZone(),
        ];
    }
}
