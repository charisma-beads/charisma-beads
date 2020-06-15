<?php

declare(strict_types=1);

namespace User\Service\Factory;

use User\Options\UserOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator): UserOptions
    {
        $config = $serviceLocator->get('config');
        $userConfig = (isset($config['user']['options'])) ? $config['user']['options'] : [];

        return new UserOptions($userConfig);
    }
}
