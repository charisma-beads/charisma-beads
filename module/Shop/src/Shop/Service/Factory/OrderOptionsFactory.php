<?php

namespace Shop\Service\Factory;

use Shop\Options\OrderOptions;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

/**
 * Class OrderOptions
 *
 * @package Shop\Service\Factory
 */
class OrderOptionsFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    $config = $serviceLocator->get('config');
	    $options = isset($config['shop']['order_options']) ? $config['shop']['order_options'] : [];
	    
	    return new OrderOptions($options);
	}
}
