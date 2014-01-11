<?php
namespace Shop\Service\Factory;

use Shop\Form\Customer\Address;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AddressFormFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    $mapper = $serviceLocator->get('Shop\Mapper\Country');
	    
	    $form = new Address();
	    $form->setCountryMapper($mapper);
	    $form->init();
	    
	    return $form;
	}
}
