<?php
namespace Navigation\Service\Form;

use Navigation\Form\Page;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PageFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $sm)
	{
		$config = $sm->get('config');
		$mapper = $sm->get('Navigation\Mapper\Page');
		
		$form = new Page();
		$form->setConfig($config);
		$form->setPageMapper($mapper);
		$form->init();
		
		return $form;
	}
}
