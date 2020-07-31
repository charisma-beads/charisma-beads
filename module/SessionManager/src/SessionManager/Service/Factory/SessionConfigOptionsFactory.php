<?php

declare(strict_types=1);


namespace SessionManager\Service\Factory;

use SessionManager\Options\SessionOptions;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\Session\Config\SessionConfig;

class SessionConfigOptionsFactory implements FactoryInterface
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
        $sessionOptions     = $serviceLocator->get(SessionOptions::class);
        $sessionConfig      = $config['session_manager']['config_options'] ?? [];
        /** @var SessionConfig $sessionConfigClass */
        $sessionConfigClass = $sessionOptions->getSessionConfigClass();
        $sessionConfigClass = new $sessionConfigClass() ;

        $sessionConfigClass->setOptions($sessionConfig);

        return $sessionConfigClass;
    }
}
