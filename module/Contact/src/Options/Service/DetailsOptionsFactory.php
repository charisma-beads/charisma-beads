<?php

declare(strict_types=1);

namespace Contact\Options\Service;

use Contact\Options\DetailsOptions;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

class DetailsOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator): DetailsOptions
    {
        $config         = $serviceLocator->get('config');
        $options        = $config['uthando_contact']['details'] ?? [];
        $options        = new DetailsOptions($options);

        return $options;
    }
}
