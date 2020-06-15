<?php

namespace Newsletter\Hydrator;

use Common\Hydrator\AbstractHydrator;
use Newsletter\Model\SubscriptionModel as SubscriptionModel;

class SubscriptionHydrator extends AbstractHydrator
{
    /**
     * @param SubscriptionModel $object
     * @return array
     */
    public function extract($object)
    {
        return [
            'subscriptionId'    => $object->getSubscriptionId(),
            'newsletterId'      => $object->getNewsletterId(),
            'subscriberId'      => $object->getSubscriberId(),
        ];
    }
}