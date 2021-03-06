<?php

namespace Mail\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Mail\Options\MailOptions;


class MailOptionsFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return array|MailOptions
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $options = (isset($config['uthando_mail'])) ? $config['uthando_mail'] : [];

        $options = new MailOptions($options);

        return $options;
    }
}
