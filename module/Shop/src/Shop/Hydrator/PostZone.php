<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;

class PostZone extends AbstractHydrator
{
    /**
     * @param \Shop\Model\PostZone $object
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
