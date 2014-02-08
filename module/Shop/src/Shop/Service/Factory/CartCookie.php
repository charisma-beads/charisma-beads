<?php
namespace Shop\Service\Factory;

use Shop\Service\Cart\Cookie as CartCookieService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CartCookie implements FactoryInterface
{

	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    $request = $serviceLocator->get('Request');
	    $response = $serviceLocator->get('Response');
	    $cookieConfig = $serviceLocator->get('Shop\Options\CartCookieOptions');
	    
        $cartCookieService = new CartCookieService();
        
        $cartCookieService->setRequest($request)
            ->setResponse($response)
            ->setCookieConfig($cookieConfig);
        
        return $cartCookieService;
	}
}
