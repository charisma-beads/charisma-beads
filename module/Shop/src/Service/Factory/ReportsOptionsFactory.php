<?php

namespace Shop\Service\Factory;

use Shop\Options\ReportsOptions;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

/**
 * Class ReportsOptions
 *
 * @package Shop\Service\Factory
 */
class ReportsOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $options = isset($config['shop']['report_options']) ? $config['shop']['report_options'] : array();

        return new ReportsOptions($options);
    }
}