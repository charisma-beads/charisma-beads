<?php

namespace Shop;

use Shop\Event\ServiceListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootStrap(MvcEvent $e)
    {
        $app = $e->getApplication();
        $eventManager = $app->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();
        
        $eventManager->attachAggregate(new ServiceListener());
        
        $sharedEventManager->attach('UthandoUser\Service\User', 'user.add', ['Shop\Event\UserEvent', 'userAdd']);
        $sharedEventManager->attach('UthandoUser\Service\User', 'user.edit', ['Shop\Event\UserEvent', 'userEdit']);
    }
    
	public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\ClassMapAutoloader' => [
                __DIR__ . '/autoload_classmap.php'
            ],
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
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
    
    public function getFormElementConfig()
    {
        return include __DIR__ . '/config/formElement.config.php';
    }
    
    public function getControllerPluginConfig()
    {
        return [
            'invokables' => [
            	'Order' => 'Shop\Controller\Plugin\Order',
            ],
        ];
    }
}
