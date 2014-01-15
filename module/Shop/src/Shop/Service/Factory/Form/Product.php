<?php

namespace Shop\Service\Factory\Form;

use Shop\Form\Product as ProductForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Product implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$categoryMapper		= $serviceLocator->get('Shop\Mapper\ProductCategory');
		$groupPriceMapper	= $serviceLocator->get('Shop\Mapper\ProductGroupPrice');
		$postUnitMapper		= $serviceLocator->get('Shop\Mapper\PostUnit');
		$sizeMapper			= $serviceLocator->get('Shop\Mapper\ProductSize');
		$taxCodeMapper		= $serviceLocator->get('Shop\Mapper\TaxCode');
		
		$form = new ProductForm();
		
		$form->setCategoryMapper($categoryMapper)
			->setGroupPriceMapper($groupPriceMapper)
			->setPostUnitMapper($postUnitMapper)
			->setSizeMapper($sizeMapper)
			->setTaxCodeMapper($taxCodeMapper);
		$form->init();
		
		return $form;
	}
}
