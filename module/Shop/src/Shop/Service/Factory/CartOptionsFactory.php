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

use Shop\Options\CartOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class CartOptions
 *
 * @package Shop\Service\Factory
 */
class CartOptionsFactory implements FactoryInterface
{

	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    $config = $serviceLocator->get('config');
	    $options = isset($config['shop']['cart_options']) ? $config['shop']['cart_options'] : array();
	    
	    return new CartOptions($options);
	}
}
