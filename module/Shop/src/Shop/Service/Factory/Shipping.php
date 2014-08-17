<?php
namespace Shop\Service\Factory;

use Shop\Service\Shipping as ShippingService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Shipping implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    /* @var $shopOptions \Shop\Options\CharismaShopOptions */
	    $shopOptions = $serviceLocator->get('Shop\Options\Shop');
	    $taxService = $serviceLocator->get('Shop\Service\Tax');
	    $countryService = $serviceLocator->get('Shop\Service\Country');
	    
	    $taxService->setTaxState($shopOptions->getVatState());
	    
	    $shippingService = new ShippingService();
	    $shippingService->setCountryService($countryService);
	    $shippingService->setTaxService($taxService);
	    
	    return $shippingService;
	}
}
