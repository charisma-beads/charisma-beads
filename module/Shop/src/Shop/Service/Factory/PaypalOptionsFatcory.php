<?php
namespace Service\Factory;

use Shop\Options\PaypalOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PaypalOptionsFatcory implements FactoryInterface
{

	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    $config = $serviceLocator->get('config');
	    $options = isset($config['shop']['paypal_options']) ? $config['shop']['paypal_options'] : array();
	     
	    return new PaypalOptions($options);
	}
}
