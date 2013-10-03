<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Users for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User;

use Zend\Mvc\MvcEvent;

class Module
{
	public function onBootstrap(MvcEvent $e)
	{
		$eventManager = $e->getApplication()->getEventManager();
		$eventManager->attach('route', array($this, 'loadConfiguration'), 2);
	}
	
	public function loadConfiguration(MvcEvent $e)
	{
		$application   = $e->getApplication();
		$sm            = $application->getServiceManager();
		$sharedManager = $application->getEventManager()->getSharedManager();
		 
		$router = $sm->get('router');
		$request = $sm->get('request');
		 
		$matchedRoute = $router->match($request);
		if (null !== $matchedRoute) {
			$sharedManager->attach('Zend\Mvc\Controller\AbstractActionController','dispatch',
				function($e) use ($sm) {
					$sm->get('ControllerPluginManager')->get('IsAllowed')
						->doAuthorization($e); //pass to the plugin...
				},2
			);
		}
	}
	
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig()
    {
    	return include __DIR__ . '/config/service.config.php';
    }
    
    public function getViewHelperConfig()
    {
        return include __DIR__ . '/config/viewHelper.config.php';
    }
    
    public function getControllerConfig()
    {
        return include __DIR__ . '/config/controller.config.php';
    }
    
    public function getControllerPluginConfig()
    {
        return include __DIR__ . '/config/controllerPlugins.config.php';
    }
    
    public function getAutoloaderConfig()
    {
    	return array(
    		'Zend\Loader\ClassMapAutoloader' => array(
    			__DIR__ . '/autoload_classmap.php'
    		),
    		'Zend\Loader\StandardAutoloader' => array(
    			'namespaces' => array(
    				__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
    			),
    		),
    	);
    }
}
