<?php

namespace Shop\Service\Factory\Form;

use Shop\Form\Post\Cost as CostForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PostCost implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$postLevelService	= $serviceLocator->get('Shop\Service\PostLevel');
		$postZoneService	= $serviceLocator->get('Shop\Service\PostZone');
		
		$form = new CostForm();
		
		$form->setPostLevelService($postLevelService)
			->setPostZoneService($postZoneService);
		$form->init();
		
		return $form;
	}
}
