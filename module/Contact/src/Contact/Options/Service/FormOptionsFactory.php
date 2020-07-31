<?php

declare(strict_types=1);

namespace Contact\Options\Service;

use Contact\Options\FormOptions;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;


class FormOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator): FormOptions
    {
        $config         = $serviceLocator->get('config');
        $options        = $config['uthando_contact']['form'] ?? [];
        $options        = new FormOptions($options);

        return $options;
    }
}
