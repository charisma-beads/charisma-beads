<?php

declare(strict_types=1);


namespace SessionManager\Service\Factory;

use SessionManager\Options\SessionOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\Config\SessionConfig;

class SessionOptionsFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config             = $serviceLocator->get('config');
        $sessionOptions     = $config['session_manager']['options'] ?? [];
        $options            = new SessionOptions($sessionOptions);

        return $options;
    }
}