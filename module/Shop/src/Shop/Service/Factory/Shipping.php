<?php
namespace Shop\Service\Factory;

use Shop\Service\Shipping as ShippingService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Shipping implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    /* @var $serviceManager \UthandoCommon\Service\ServiceManager */
	    $serviceManager = $serviceLocator->get('UthandoServiceManager');
	    
	    /* @var $shopOptions \Shop\Options\ShopOptions */
	    $shopOptions = $serviceLocator->get('Shop\Options\Shop');
	    $taxService = $serviceLocator->get('Shop\Service\Tax');
	    $countryService = $serviceManager->get('ShopCountry');
	    
	    $taxService->setTaxState($shopOptions->getVatState());
	    
	    $shippingService = new ShippingService();
	    $shippingService->setCountryService($countryService);
	    $shippingService->setTaxService($taxService);
		$shippingService->setShippingByWeight($shopOptions->getPostState());
	    
	    return $shippingService;
	}
}