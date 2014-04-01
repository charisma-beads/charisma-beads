<?php
namespace Shop\Hydrator\Post;

use Application\Hydrator\AbstractHydrator;

class Zone extends AbstractHydrator
{
    /**
     * @param \Shop\Model\Post\Zone $object
     * @return array $data
     */
    public function extract($object)
    {
        return array(
        	'postZoneId'   => $object->getPostZoneId(),
            'taxCodeId'    => $object->getTaxCodeId(),
            'zone'         => $object->getZone(),
        );
    }
}
