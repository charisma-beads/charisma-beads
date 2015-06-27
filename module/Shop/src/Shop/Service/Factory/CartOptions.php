<?php
namespace Shop\Service\Factory;

use Shop\Options\CartOptions as Options;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CartOptions implements FactoryInterface
{

	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    $config = $serviceLocator->get('config');
	    $options = isset($config['shop']['cart_options']) ? $config['shop']['cart_options'] : array();
	    
	    return new Options($options);
	}
}
