<?php
namespace Shop\Service\Factory;

use Shop\Service\Shipping;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ShippingFactory implements FactoryInterface
{

	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    $taxService = $serviceLocator->get('Shop\Service\Tax');
	    $countryService = $serviceLocator->get('Shop\Service\Country');
	    
	    $shippingService = new Shipping();
	    $shippingService->setCountryService($countryService);
	    $shippingService->setTaxService($taxService);
	    
	    return $shippingService;
	}
}
