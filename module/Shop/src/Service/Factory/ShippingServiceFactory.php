<?php

namespace Shop\Service\Factory;

use Shop\Options\CartOptions;
use Shop\Service\CountryService;
use Shop\Service\ShippingService;
use Shop\Service\TaxService;
use Common\Service\ServiceManager;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

/**
 * Class Shipping
 *
 * @package Shop\Service\Factory
 */
class ShippingServiceFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    /* @var $serviceManager \Common\Service\ServiceManager */
	    $serviceManager = $serviceLocator->get(ServiceManager::class);
	    
	    /* @var $cartOptions \Shop\Options\CartOptions */
	    $cartOptions = $serviceLocator->get(CartOptions::class);
	    $taxService = $serviceLocator->get(TaxService::class);
	    $countryService = $serviceManager->get(CountryService::class);
	    
	    $shippingService = new ShippingService();
	    $shippingService->setCountryService($countryService);
	    $shippingService->setTaxService($taxService);
		$shippingService->setShippingByWeight($cartOptions->isShippingByWeight());
	    
	    return $shippingService;
	}
}
