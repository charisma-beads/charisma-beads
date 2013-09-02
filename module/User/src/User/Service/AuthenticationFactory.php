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
        $model = $sm->get('User\Model\User');
        $config = $sm->get('config');
        
        $auth = new Authentication();
        
        $auth->setDbAdapter($dbAdapter);
        $auth->setUserModel($model);
        $auth->setOptions($config['user']['auth']);
        
        return $auth;
    }
}
