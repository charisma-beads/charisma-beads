<?php

namespace Common\Service\Factory;

use Common\Options\AkismetOptions;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;


class AkismetOptionsFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator): AkismetOptions
    {
        $config = $serviceLocator->get('config');
        $options = $config['common']['akismet'] ?? [];

        return new AkismetOptions($options);
    }
}