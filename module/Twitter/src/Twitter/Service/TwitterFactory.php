<?php

namespace Twitter\Service;

use Twitter\Option\TwitterOptions;
use Twitter\Service\Twitter as TwitterService;
use Traversable;
use Zend\Cache\Storage\Adapter\AbstractAdapter;
use Zend\Cache\StorageFactory;
use ZendService\Twitter\Twitter as ZendTwitter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\ArrayUtils;


class TwitterFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $services
     * @return mixed|Twitter
     */
    public function createService(ServiceLocatorInterface $services)
    {
        $config = $services->get('config');

        if ($config instanceof Traversable) {
            $config = ArrayUtils::iteratorToArray($config);
        }

        /* @var TwitterOptions $options */
        $options = $services->get(TwitterOptions::class);

        //$config = $config['uthando_social_media']['twitter'];
        $twitter = new ZendTwitter($options->getOauthOptions());


        /* @var AbstractAdapter $cache */
        $cache = ($options->getCache()) ? StorageFactory::factory($options->getCache()) : null;

        $service = new TwitterService();

        $service->setOptions($options->toArray())
            ->setTwitter($twitter)
            ->setCache($cache);

        return $service;
    }
}
