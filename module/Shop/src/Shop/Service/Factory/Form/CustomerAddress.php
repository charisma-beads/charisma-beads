<?php
namespace Shop\Service\Factory\Form;

use Shop\Form\Customer\Address as AddressForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CustomerAddress implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    $mapper = $serviceLocator->get('Shop\Mapper\Country');
	    
	    $form = new AddressForm();
	    $form->setCountryMapper($mapper);
	    $form->init();
	    
	    return $form;
	}
}
