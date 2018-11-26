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
use Shop\Service\CartCookieService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class CartCookie
 *
 * @package Shop\Service\Factory
 */
class CartCookieFactory implements FactoryInterface
{

	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    $request = $serviceLocator->get('Request');
	    $response = $serviceLocator->get('Response');
	    $cookieConfig = $serviceLocator->get(CartCookieOptions::class);
	    
        $cartCookieService = new CartCookieService();
        
        $cartCookieService->setRequest($request)
            ->setResponse($response)
            ->setCookieConfig($cookieConfig);
        
        return $cartCookieService;
	}
}
