<?php

declare(strict_types=1);

namespace User\Service\Factory;

use User\Options\LoginOptions;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

class LoginOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator): LoginOptions
    {
        $config = $serviceLocator->get('config');
        $userConfig = (isset($config['user']['login_options'])) ? $config['user']['login_options'] : [];

        return new LoginOptions($userConfig);
    }
}
