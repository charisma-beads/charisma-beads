<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Factory
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service\Factory;

use Shop\Options\CartOptions;
use Shop\Service\CountryService;
use Shop\Service\ShippingService;
use Shop\Service\TaxService;
use UthandoCommon\Service\ServiceManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class Shipping
 *
 * @package Shop\Service\Factory
 */
class ShippingServiceFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    /* @var $serviceManager \UthandoCommon\Service\ServiceManager */
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
