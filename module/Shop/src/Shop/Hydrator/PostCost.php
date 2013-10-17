<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;

class PostCost extends AbstractHydrator
{
    /**
     * @param \Shop\Model\PostCost $object
     * @return array $data
     */
    public function extract($object)
    {
        return array(
        	'postCostId'    => $object->getPostCostId(),
            'postLevelId'   => $object->getPostLevelId(),
            'postZoneId'    => $object->getPostZoneId(),
            'cost'          => $object->getCost(),
            'vatInc'        => $object->getVatInc(),
        );
    }
}
