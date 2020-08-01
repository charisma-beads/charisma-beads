<?php

namespace Shop\Service\Factory;

use Shop\Options\NewProductsCarouselOptions;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

/**
 * Class NewProductsCarouselOptions
 *
 * @package Shop\Service\Factory
 */
class NewProductsCarouselOptionsFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    $config = $serviceLocator->get('config');
	    $options = isset($config['shop']['new_products_carousel']) ? $config['shop']['new_products_carousel'] : [];

	    
	    return new NewProductsCarouselOptions($options);
	}
}
