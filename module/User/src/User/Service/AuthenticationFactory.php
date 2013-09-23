<?php

namespace User\Service;

use User\Model\Authentication;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthenticationFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $mapper= $sm->get('User\Mapper\User');
        $config = $sm->get('config');
        
        $auth = new Authentication();
        
        $auth->setDbAdapter($dbAdapter);
        $auth->setUserMapper($mapper);
        $auth->setOptions($config['user']['auth']);
        
        return $auth;
    }
}
