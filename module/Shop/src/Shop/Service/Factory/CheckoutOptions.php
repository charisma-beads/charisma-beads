<?php
namespace Shop\Service\Factory;

use Shop\Options\CheckoutOptions as Options;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CheckoutOptions implements FactoryInterface
{

	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    $config = $serviceLocator->get('config');
	    $options = isset($config['shop']['checkout_options']) ? $config['shop']['checkout_options'] : array();
	    
	    return new Options($options);
	}
}
