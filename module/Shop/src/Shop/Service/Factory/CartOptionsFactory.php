<?php

namespace Shop\Service\Factory;

use Shop\Options\CartOptions;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

/**
 * Class CartOptions
 *
 * @package Shop\Service\Factory
 */
class CartOptionsFactory implements FactoryInterface
{

	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    $config = $serviceLocator->get('config');
	    $options = isset($config['shop']['cart_options']) ? $config['shop']['cart_options'] : array();
	    
	    return new CartOptions($options);
	}
}
