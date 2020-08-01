<?php

namespace Newsletter\Service;


use Common\Service\AbstractMapperService;
use Newsletter\Hydrator\SubscriptionHydrator;
use Newsletter\Mapper\SubscriptionMapper;
use Newsletter\Model\SubscriptionModel;

/**
 * Class Subscription
 *
 * @package Newsletter\Service
 * @method SubscriptionMapper getMapper($mapperClass = null, array $options = [])
 */
class SubscriptionService extends AbstractMapperService
{
    protected $hydrator     = SubscriptionHydrator::class;
    protected $mapper       = SubscriptionMapper::class;
    protected $model        = SubscriptionModel::class;

    /**
     * @param $id
     * @return array
     */
    public function getSubscriptionsBySubscriberId($id)
    {
        $id = (int) $id;

        $subscriptions = $this->getMapper()->getSubscriptionsBySubscriberId($id);

        $newsletterSubscriptions = [];

        foreach ($subscriptions as $subscription) {
            $newsletterSubscriptions[] = $subscription;
        }

        return $newsletterSubscriptions;
    }
}