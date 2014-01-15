<?php

namespace Shop\Service\Factory;

use Shop\Form\Post\Cost;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PostCostFormFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$postLevelService	= $serviceLocator->get('Shop\Service\PostLevel');
		$postZoneService	= $serviceLocator->get('Shop\Service\PostZone');
		
		$form = new Cost();
		
		$form->setPostLevelService($postLevelService)
			->setPostZoneService($postZoneService);
		$form->init();
		
		return $form;
	}
}
