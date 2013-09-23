<?php

namespace Application\Model;

use DateTime;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractMapper implements ServiceLocatorAwareInterface
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;
    
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
     * get application config option by its key.
     * 
     * @param string $key
     * @return array $config
     */
    protected function getConfig($key)
    {
    	$config = $this->getServiceLocator()->get('config');
    	return $config[$key];
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
