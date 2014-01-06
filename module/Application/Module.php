<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Exception;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;
use Zend\Console\Adapter\AdapterInterface as Console;

use Zend\Session\Container;

class Module implements
    ConsoleUsageProviderInterface,
    ConsoleBannerProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $app                 = $e->getApplication();
        $eventManager        = $app->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $sharedEventManager  = $eventManager->getSharedManager();
        $config              = $app->getConfig();
        
        if (true === $config['application']['ssl']) {
            $eventManager->attach(
            	MvcEvent::EVENT_ROUTE,
            	array('Application\Event\Ssl', 'checkSsl'),
                -100000
            );
        }
        
        if (isset($config['php_settings'])) {
        	foreach ($config['php_settings'] as $key => $value) {
        		ini_set($key, $value);
        	}
        }
        
        $this->bootstrapSession($e);
    }
    
    public function bootstrapSession($e)
    {
        try {
        	$session = $e->getApplication()
        	   ->getServiceManager()
        	   ->get('Application\SessionManager');
        	$session->start();
        
        	$container = new Container();
        	if (!isset($container->init)) {
        		$session->regenerateId(true);
        		$container->init = 1;
        	}
        } catch (Exception $e) {
            echo '<pre>';
            echo $e->getMessage();
            echo '</pre';
            exit();
        }
    }
    
    public function getConsoleUsage(Console $console)
    {
        return array(
            'mailqueue send' => 'send the next batch of mail in the mail queue',
        );
    }
    
    public function getConsoleBanner(Console $console){
        return
            "==------------------------------------------------------==\n" .
            "        Welcome to my ZF2 Console-enabled app             \n" .
            "==------------------------------------------------------==\n" .
            "Version 1.0\n"
        ;
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
