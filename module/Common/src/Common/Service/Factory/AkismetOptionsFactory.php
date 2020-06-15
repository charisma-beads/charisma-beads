<?php

namespace Common\Service\Factory;

use Common\Options\AkismetOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


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
        $options = $config['uthando_common']['akismet'] ?? [];

        return new AkismetOptions($options);
    }
}