<?php

namespace News\Service;

use News\Options\FeedOptions;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

class NewsFeedOptionsFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return FeedOptions
     */
    public function createService(ServiceLocatorInterface $serviceLocator) : FeedOptions
    {
        $config     = $serviceLocator->get('config');
        $config     = $config['uthando_news']['feed'] ?? [];
        $options    = new FeedOptions($config);

        return $options;
    }
}

