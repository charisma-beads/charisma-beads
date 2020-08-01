<?php

namespace Shop\Service\Factory;

use Shop\Options\PaypalOptions;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

/**
 * Class PaypalOptions
 *
 * @package Shop\Service\Factory
 */
class PaypalOptionsFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    $config = $serviceLocator->get('config');
	    $options = isset($config['shop']['paypal_options']) ? $config['shop']['paypal_options'] : [];
	    
	    return new PaypalOptions($options);
	}
}
