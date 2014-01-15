<?php

namespace Shop\Service\Factory\Form;

use Shop\Form\Post\Zone as ZoneForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PostZone implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$taxCodeService	= $serviceLocator->get('Shop\Service\TaxCode');
		
		$form = new ZoneForm();
		
		$form->setTaxCodeService($taxCodeService);
		$form->init();
		
		return $form;
	}
}
