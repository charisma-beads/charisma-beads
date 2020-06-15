<?php

namespace ThemeManager\Service;

use ThemeManager\Options\ThemeOptions as Options;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class ThemeOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $options = isset($config['uthando_theme_manager']) ? $config['uthando_theme_manager'] : [];

        return new Options($options);

    }
}
