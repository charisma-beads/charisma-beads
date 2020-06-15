<?php

declare(strict_types=1);

namespace Contact\Options\Service;

use Contact\Options\GoogleMapOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class GoogleMapOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator): GoogleMapOptions
    {
        $config         = $serviceLocator->get('config');
        $formOptions    = $config['uthando_contact']['google_map'] ?? [];
        $options        = new GoogleMapOptions($formOptions);

        return $options;
    }
}
