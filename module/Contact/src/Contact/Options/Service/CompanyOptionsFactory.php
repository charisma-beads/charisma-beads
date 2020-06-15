<?php

declare(strict_types=1);

namespace Contact\Options\Service;

use Contact\Options\CompanyOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CompanyOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator): CompanyOptions
    {
        $config         = $serviceLocator->get('config');
        $options        = $config['uthando_contact']['company'] ?? [];
        $options        = new CompanyOptions($options);

        return $options;
    }
}
