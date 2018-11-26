<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Factory
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service\Factory;

use Shop\Options\NewProductsCarouselOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

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
