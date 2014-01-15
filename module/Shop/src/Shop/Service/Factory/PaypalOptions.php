<?php
namespace Service\Factory;

use Shop\Options\PaypalOptions as Options;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PaypalOptions implements FactoryInterface
{

	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    $config = $serviceLocator->get('config');
	    $options = isset($config['shop']['paypal_options']) ? $config['shop']['paypal_options'] : array();
	     
	    return new Options($options);
	}
}
