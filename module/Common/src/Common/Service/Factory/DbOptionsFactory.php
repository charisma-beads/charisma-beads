<?php

namespace Common\Service\Factory;

use Common\Options\DbOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class DbOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $dbOptions = (isset($config['uthando_common']['db_options'])) ? $config['uthando_common']['db_options'] : [];

        return new DbOptions($dbOptions);
    }
}
