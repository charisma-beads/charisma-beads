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
	    $shopOptions = $serviceLocator->get('Shop\Options\Shop');
	    
	    $taxService->setTaxState($shopOptions->getVatState());
	    
        $cartService = new Cart();
        
        $cartService->setTaxService($taxService);
        $cartService->loadSession();
        
        return $cartService;
	}
}
