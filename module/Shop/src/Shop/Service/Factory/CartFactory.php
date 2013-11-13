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
	    $productCategoryService = $serviceLocator->get('Shop\Service\ProductCategory');
	    
        $cartService = new Cart();
        
        $cartService->setTaxService($taxService);
        $cartService->setProductCategoryService($productCategoryService);
        $cartService->loadSession();
        
        return $cartService;
	}
}
