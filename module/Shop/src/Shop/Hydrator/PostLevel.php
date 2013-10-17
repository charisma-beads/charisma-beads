<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;

class PostLevel extends AbstractHydrator
{
    /**
     * @param \Shop\Model\PostLevel $object
     * @return array $data
     */
    public function extract($object)
    {
        return array(
        	'postLevelId'   => $object->getPostLevelId(),
            'postLevel'     => $object->getPostLevel(),
        );
    }
}
