<?php

namespace User\Service\Factory;

use User\Service\Authentication;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthenticationFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        $service = $sm->get('User\Service\User');
        $config = $sm->get('config');
        
        $auth = new Authentication();
        
        $auth->setUserService($service);
        $auth->setOptions($config['user']['auth']);
        
        return $auth;
    }
}
