<?php

namespace Shop\Service\Factory;

use Shop\Options\ShopOptions;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

/**
 * Class ShopOptions
 *
 * @package Shop\Service\Factory
 */
class ShopOptionsFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    $config = $serviceLocator->get('config');
	    $options = isset($config['shop']['shop_options']) ? $config['shop']['shop_options'] : [];

	    
	    return new ShopOptions($options);
	}
}
