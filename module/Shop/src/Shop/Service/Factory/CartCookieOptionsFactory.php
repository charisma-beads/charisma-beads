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

use Shop\Options\CartCookieOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class CartCookieOptions
 *
 * @package Shop\Service\Factory
 */
class CartCookieOptionsFactory implements FactoryInterface
{

	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    $config = $serviceLocator->get('config');
	    $options = isset($config['shop']['cart_cookie']) ? $config['shop']['cart_cookie'] : array();
	     
	    return new CartCookieOptions($options);
	}
}
