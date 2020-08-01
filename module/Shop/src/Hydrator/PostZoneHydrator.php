<?php

namespace Shop\Hydrator;

use Common\Hydrator\AbstractHydrator;

/**
 * Class Zone
 *
 * @package Shop\Hydrator
 */
class PostZoneHydrator extends AbstractHydrator
{
    /**
     * @param \Shop\Model\PostZoneModel $object
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
