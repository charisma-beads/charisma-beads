<?php

declare(strict_types=1);

namespace User\Service\Factory;

use User\Options\AuthOptions;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

class AuthOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator): AuthOptions
    {
        $config = $serviceLocator->get('config');
        $authOptions = (isset($config['user']['auth'])) ? $config['user']['auth'] : [];

        return new AuthOptions($authOptions);
    }
}
