<?php

namespace Shop\Service\Factory\Form;

use Shop\Form\Product\Category as CategoryForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ProductCategory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$categoryService	= $serviceLocator->get('Shop\Service\ProductCategory');
		$imageMapper		= $serviceLocator->get('Shop\Mapper\ProductImage');
		$params				= $serviceLocator->get('Application')
								->getMvcEvent()
								->getRouteMatch()
								->getParams();
		 
		$categoryId			= (isset($params['id'])) ? $params['id'] : 0;
		
		$form = new CategoryForm();
		
		$form->setCategoryService($categoryService)
			->setImageMapper($imageMapper)
			->setCategoryId($categoryId);
		$form->init();
		
		return $form;
	}
}
