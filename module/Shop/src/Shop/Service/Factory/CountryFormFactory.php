<?php

namespace Shop\Service\Factory;

use Shop\Form\Country;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CountryFormFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$postZoneService	= $serviceLocator->get('Shop\Service\PostZone');
		
		$form = new Country();
		
		$form->setPostZoneService($postZoneService);
		$form->init();
		
		return $form;
	}
}
