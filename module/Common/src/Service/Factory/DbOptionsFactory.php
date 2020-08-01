<?php

namespace Common\Service\Factory;

use Common\Options\DbOptions;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;


class DbOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $dbOptions = (isset($config['common']['db_options'])) ? $config['common']['db_options'] : [];

        return new DbOptions($dbOptions);
    }
}
