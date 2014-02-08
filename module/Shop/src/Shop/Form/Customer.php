<?php

namespace Shop\Form;

use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class Customer extends Form implements ServiceLocatorAwareInterface
{	
    use ServiceLocatorAwareTrait;
    
	public function init()
	{
	    
	}
}
