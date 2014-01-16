<?php

namespace Shop\Service\Factory\Form;

use Shop\Form\Tax\Code as TaxCodeForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Country implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$taxRateService	= $serviceLocator->get('Shop\Service\TaxRate');
		
		$form = new TaxCodeForm();
		
		$form->setTaxRateService($taxRateService);
		$form->init();
		
		return $form;
	}
}
