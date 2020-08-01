<?php

namespace Shop\Hydrator;

use Common\Hydrator\AbstractHydrator;

/**
 * Class Level
 *
 * @package Shop\Hydrator
 */
class PostLevelHydrator extends AbstractHydrator
{
    /**
     * @param \Shop\Model\PostLevelModel $object
     * @return array $data
     */
    public function extract($object)
    {
        return [
        	'postLevelId'   => $object->getPostLevelId(),
            'postLevel'     => $object->getPostLevel(),
        ];
    }
}
