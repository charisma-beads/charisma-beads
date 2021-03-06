<?php

declare(strict_types=1);

namespace FileManager\Options\Factory;


use FileManager\Options\ElfinderOptions;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

class ElfinderOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator): ElfinderOptions
    {
        $config = $serviceLocator->get('config');
        $options = $config['uthando_file_manager']['elfinder'] ?? [];

        return new ElfinderOptions($options);
    }
}
