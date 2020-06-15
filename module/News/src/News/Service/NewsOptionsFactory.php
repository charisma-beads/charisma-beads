<?php

namespace News\Service;

use News\Options\NewsOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class NewsOptionsFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return NewsOptions
     */
    public function createService(ServiceLocatorInterface $serviceLocator) : NewsOptions
    {
        $config     = $serviceLocator->get('config');
        $config     = $config['uthando_news']['options'] ?? [];
        $options    = new NewsOptions($config);

        return $options;
    }
}
