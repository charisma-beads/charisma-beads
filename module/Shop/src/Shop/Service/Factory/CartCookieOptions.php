<?php
namespace Shop\Service\Factory;

use Shop\Options\CartCookieOptions as Options;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CartCookieOptions implements FactoryInterface
{

	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    $config = $serviceLocator->get('config');
	    $options = isset($config['shop']['cart_cookie']) ? $config['shop']['cart_cookie'] : array();
	     
	    return new Options($options);
	}
}
