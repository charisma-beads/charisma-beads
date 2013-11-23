<?php
namespace Shop\Service\Factory;

use Shop\Options\ShopOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ShopOptionsFactory implements FactoryInterface
{

	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    $config = $serviceLocator->get('config');
	    $options = isset($config['shop']['shop_options']) ? $config['shop']['shop_options'] : array();
	    
	    return new ShopOptions($options);
	}
}
