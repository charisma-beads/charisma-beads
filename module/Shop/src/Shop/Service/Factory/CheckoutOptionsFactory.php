<?php
namespace Shop\Service\Factory;

use Shop\Options\CheckoutOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CheckoutOptionsFactory implements FactoryInterface
{

	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    $config = $serviceLocator->get('config');
	    $options = isset($config['shop']['checkout_options']) ? $config['shop']['checkout_options'] : array();
	     
	    return new CheckoutOptions($options);
	}
}
