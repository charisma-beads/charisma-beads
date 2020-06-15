<?php

namespace Newsletter\Hydrator;

use Common\Hydrator\AbstractHydrator;
use Common\Hydrator\Strategy\DateTime as DateTimeStrategy;


class SubscriberHydrator extends AbstractHydrator
{
    public function __construct()
    {
        parent::__construct();

        $this->addStrategy('dateCreated', new DateTimeStrategy());
    }
    /**
     * @param \Newsletter\Model\SubscriberModel $object
     * @return array
     */
    public function extract($object)
    {
        return [
            'subscriberId'  => $object->getSubscriberId(),
            'name'          => $object->getName(),
            'email'         => $object->getEmail(),
            'dateCreated'   => $this->extractValue('dateCreated', $object->getDateCreated()),
        ];
    }
}