<?php

declare(strict_types=1);

namespace User\Service\Factory;

use Common\Service\ServiceManager;
use User\Authentication\Storage;
use User\Options\AuthOptions;
use User\Service\Authentication;
use User\Service\UserService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthenticationFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm): Authentication
    {
        $service = $sm->get(ServiceManager::class)->get(UserService::class);
        $storage = $sm->get(Storage::class);
        $options = $sm->get(AuthOptions::class);

        $auth = new Authentication();

        $auth->setUserService($service);
        $auth->setOptions($options);
        $auth->setStorage($storage);

        return $auth;
    }
}
