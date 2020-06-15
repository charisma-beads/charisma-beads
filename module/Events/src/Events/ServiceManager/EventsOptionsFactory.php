<?php

namespace Events\ServiceManager;

use Events\Options\EventsOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class EventsOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config         = $serviceLocator->get('config');
        $eventsOptions    = (isset($config['uthando_events'])) ? $config['uthando_events'] : [];
        $options        = new EventsOptions($eventsOptions);

        return $options;
    }
}
