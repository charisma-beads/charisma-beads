<?php

namespace SessionManager\Hydrator;

use SessionManager\Model\SessionModel;
use Common\Hydrator\AbstractHydrator;

class SessionHydrator extends AbstractHydrator
{
    /**
     * @param SessionModel $object
     * @return array
     */
    public function extract($object)
    {
        return [
            'id' => $object->getId(),
            'name' => $object->getName(),
            'modified' => $object->getModified(),
            'lifetime' => $object->getLifetime(),
            'data' => $object->getData()
        ];
    }
}
