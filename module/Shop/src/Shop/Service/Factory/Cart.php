<?php
namespace Shop\Service\Factory;

use Shop\Service\Cart as CartService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Cart implements FactoryInterface
{

	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    $taxService = $serviceLocator->get('Shop\Service\Tax');
	    $shopOptions = $serviceLocator->get('Shop\Options\Shop');
	    
	    $taxService->setTaxState($shopOptions->getVatState());
	    
        $cartService = new CartService();
        
        $cartService->setTaxService($taxService);
        $cartService->loadSession();
        
        return $cartService;
	}
}
