<?php
namespace Shop\Service\Factory;

use Shop\Service\Tax;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TaxFactory implements FactoryInterface
{

	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    $taxRateService = $serviceLocator->get('Shop\Service\TaxRate');
	    
	    $tax = new Tax();
	    $tax->setTaxRateService($taxRateService);
	    
	    return $tax;
	}
}
