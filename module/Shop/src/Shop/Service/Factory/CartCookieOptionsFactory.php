<?php

namespace Shop\Service\Factory;

use Shop\Options\CartCookieOptions;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

/**
 * Class CartCookieOptions
 *
 * @package Shop\Service\Factory
 */
class CartCookieOptionsFactory implements FactoryInterface
{

	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    $config = $serviceLocator->get('config');
	    $options = isset($config['shop']['cart_cookie']) ? $config['shop']['cart_cookie'] : array();
	     
	    return new CartCookieOptions($options);
	}
}
