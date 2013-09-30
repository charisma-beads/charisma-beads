<?php

namespace User\Service\Factory;

use User\Controller\AuthController;
use User\Form\Login as LoginForm;
use User\InputFilter\Login as LoginFilter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        $serviceLocator = $services->getServiceLocator();
        $auth           = $serviceLocator->get('Zend\Authentication\AuthenticationService');
        
        $filter  = new LoginFilter();
        $form    = new LoginForm();
        $form->setInputFilter($filter);

        $controller = new AuthController();
        $controller->setLoginForm($form);
        $controller->setAuthService($auth);
        
        return $controller;
    }
}
