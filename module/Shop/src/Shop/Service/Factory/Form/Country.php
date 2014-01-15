<?php

namespace Shop\Service\Factory\Form;

use Shop\Form\Country as CountryForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Country implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$postZoneService	= $serviceLocator->get('Shop\Service\PostZone');
		
		$form = new CountryForm();
		
		$form->setPostZoneService($postZoneService);
		$form->init();
		
		return $form;
	}
}
