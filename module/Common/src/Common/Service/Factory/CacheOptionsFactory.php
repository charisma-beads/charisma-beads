<?php

namespace Common\Service\Factory;

use Common\Options\CacheOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CacheOptionsFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator): CacheOptions
    {
        $config = $serviceLocator->get('config');
        $options = $config['uthando_common']['cache'] ?? [];

        return new CacheOptions($options);
    }
}