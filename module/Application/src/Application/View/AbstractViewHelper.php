<?php
/**
 * Application
 * 
 * @author
 * @version 
 */
namespace Application\View;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Exception\InvalidArgumentException;
use Zend\View\Helper\AbstractHelper;

/**
 * View Helper
 */
class AbstractViewHelper extends AbstractHelper implements ServiceLocatorAwareInterface
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;
    
    /**
     * @var array
     */
    protected $config;
    
    /**
     * Gets the config options as an array, if a key is supplied then that keys options is returned.
     * 
     * @param string $key
     * @throws array|InvalidArgumentException
     */
    protected function getConfig($key=null)
    {
        if ($this->config === null) {
            $this->setConfig();
        }
        
        if (null === $key) {
            return $this->config;
        }
        
        if (!array_key_exists($key, $this->config)) {
            throw new InvalidArgumentException("key: '" . $key . "' is not set in configuration options.");
        }
        
        return $this->config[$key];
    }
    
    /**
     * Sets the config array.
     * 
     * @return \Application\View\AbstractHelper
     */
    protected function setConfig()
    {
        $this->config = $this->serviceLocator->getServiceLocator()
            ->getServiceLocator()->get('config');
        return $this;
    }
    
    /**
     * Set the service locator.
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Application\View\AbstractHelper
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
