<?php
namespace Shop\Service\Factory;

use Shop\Service\Cart;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CartFactory implements FactoryInterface
{

	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    $taxService = $serviceLocator->get('Shop\Service\Tax');
	    
        $cartService = new Cart();
        
        $cartService->setTaxService($taxService);
        $cartService->loadSession();
        
        return $cartService;
	}
}
