<?php

namespace Shop\Service\Factory;

use Shop\Options\CartCookieOptions;
use Shop\Service\CartCookieService;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

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
