<?php

namespace Shop\Exception;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

/**
 * Class MailerFactory
 *
 * @package Shop\Exception
 */
class MailerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $service = new Mailer($config);
        $service->setServiceManager($serviceLocator);

        return $service;
    }
}
