<?php

namespace Shop\Hydrator;

use Common\Hydrator\AbstractHydrator;

/**
 * Class Cost
 *
 * @package Shop\Hydrator
 */
class PostCostHydrator extends AbstractHydrator
{   
    /**
     * @param \Shop\Model\PostCostModel $object
     * @return array $data
     */
    public function extract($object)
    {
        return [
        	'postCostId'    => $object->getPostCostId(),
            'postLevelId'   => $object->getPostLevelId(),
            'postZoneId'    => $object->getPostZoneId(),
            'cost'          => $object->getCost(),
            'vatInc'        => $object->getVatInc(),
        ];
    }
}
