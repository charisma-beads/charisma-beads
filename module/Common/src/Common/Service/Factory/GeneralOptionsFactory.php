<?php

declare(strict_types=1);

namespace Common\Service\Factory;

use Common\Options\GeneralOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class GeneralOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator): GeneralOptions
    {
        $config = $serviceLocator->get('config');
        $options = $config['common']['general'] ?? [];

        return new GeneralOptions($options);
    }
}
