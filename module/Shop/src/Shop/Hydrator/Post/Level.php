<?php
namespace Shop\Hydrator\Post;

use UthandoCommon\Hydrator\AbstractHydrator;

class Level extends AbstractHydrator
{
    /**
     * @param \Shop\Model\Post\Level $object
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
