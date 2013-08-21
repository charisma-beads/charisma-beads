<?php

namespace Application\Model;

use DateTime;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractModel implements ServiceLocatorAwareInterface
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;
    
    /**
     * Database adapter
     * 
     * @var string
     */
    protected $dbAdapter = 'Zend\Db\Adapter\Adapter';
    
    /**
     * Holds an array of tablegateway instances
     * 
     * @var array
     */
    protected $gateways = array();
    
    /**
     * Holds an array of form instances
     * 
     * @var array
     */
    protected $forms = array();
    
    /**
     * Holds an array of entity instances.
     * 
     * @var array
     */
    protected $entities = array();
    
    /**
     * an array of class maps for less typing!
     * 
     * @var array
     */
    protected $classMap = array();
    
    /**
     * String format for date conversion
     * 
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';
    
    /**
     * Get the current date formated to $dateFormat
     * 
     * @return string
     */
    public function currentDate()
    {
    	$date = new DateTime();
    	return $date->format($this->dateFormat);
    }
    
    /**
     * Get a data gateway by its name.
     * 
     * @param string $name
     * @return Application\Model\AbstractModel
     */
    public function getGateway($name)
    {
        if (!isset($this->gateways[$name])) {
        	$class = $this->classMap['gateways'][$name];
            $dbAdapter = $this->getServiceLocator()->get($this->dbAdapter);
            $this->gateways[$name] = new $class($dbAdapter);
        }
        
        return $this->gateways[$name];
    }
    
    /**
     * Get a entity by its name
     * 
     * @param string $name
     * @return Application\Model\Entity\AbstractEntity
     */
    public function getEntity($name)
    {
    	$class = $this->classMap['entities'][$name];
    	return new $class();
    }
    
    /**
     * Get a form by its name
     * 
     * @param string $name
     * @return Zend\Form\Form
     */
    public function getForm($name)
    {
    	if (!isset($this->forms[$name])) {
    		$class = $this->classMap['forms'][$name];
    		$this->forms[$name] = new $class($this->getServiceLocator());
    	}
    	
    	return $this->forms[$name];
    }

    /**
     * Set the service locator.
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Application\Model\AbstractModel
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }
    
    /**
     * Get the service locator.
     *
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
}
