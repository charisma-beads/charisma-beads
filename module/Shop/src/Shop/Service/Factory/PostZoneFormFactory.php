<?php

namespace Shop\Service\Factory;

use Shop\Form\Post\Zone;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PostZoneFormFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$taxCodeService	= $serviceLocator->get('Shop\Service\TaxCode');
		
		$form = new Zone();
		
		$form->setTaxCodeService($taxCodeService);
		$form->init();
		
		return $form;
	}
}
