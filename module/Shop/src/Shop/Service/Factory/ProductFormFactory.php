<?php

namespace Shop\Service\Factory;

use Shop\Form\Product;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ProductFormFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$categoryMapper		= $serviceLocator->get('Shop\Mapper\ProductCategory');
		$groupPriceMapper	= $serviceLocator->get('Shop\Mapper\ProductGroupPrice');
		$postUnitMapper		= $serviceLocator->get('Shop\Mapper\PostUnit');
		$sizeMapper			= $serviceLocator->get('Shop\Mapper\ProductSize');
		$taxCodeMapper		= $serviceLocator->get('Shop\Mapper\TaxCode');
		
		$form = new Product();
		
		$form->setCategoryMapper($categoryMapper)
			->setGroupPriceMapper($groupPriceMapper)
			->setPostUnitMapper($postUnitMapper)
			->setSizeMapper($sizeMapper)
			->setTaxCodeMapper($taxCodeMapper);
		$form->init();
		
		return $form;
	}
}
