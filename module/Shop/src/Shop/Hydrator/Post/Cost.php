<?php
namespace Shop\Hydrator\Post;

use Application\Hydrator\AbstractHydrator;

class Cost extends AbstractHydrator
{
    protected $prefix = 'postCost.';
    
    /**
     * @param \Shop\Model\Post\Cost $object
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
