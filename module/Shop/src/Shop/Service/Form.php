<?php
namespace Shop\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Form implements ServiceLocatorAwareInterface
{
    
    protected $serviceLocator;
    
    public function getForm($form, $model=null, $data=null)
    {
        $sl = $this->getServiceLocator();
        $form = $sl->get($form);
        $form->setInputFilter($sl->get($this->inputFilter));
        $form->setHydrator($this->getMapper()->getHydrator());
        	
        if ($model) {
            $form->bind($model);
        }
        	
        if ($data) {
            $form->setData($data);
        }
    
        return $form;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
}
