<?php

declare(strict_types=1);

namespace FileManager\Options\Factory;

use FileManager\Options\FileManagerOptions;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;


class FileManagerOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator): FileManagerOptions
    {
        $config = $serviceLocator->get('config');
        $options = $config['uthando_file_manager']['options'] ?? [];

        return new FileManagerOptions($options);
    }
}
