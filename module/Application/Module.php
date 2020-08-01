<?php

namespace Application;

use Laminas\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $event)
    {
        $app                    = $event->getApplication();
        $eventManager           = $app->getEventManager();
        $moduleRouteListener    = $app->getServiceManager()
            ->get('ModuleRouteListener');
        
        $moduleRouteListener->attach($eventManager);
        $eventManager->attach(MvcEvent::EVENT_ROUTE, [$this, 'setPhpSettings']);
    }

    public function setPhpSettings(MvcEvent $event)
    {
        // we could have different setting for different route.
        // in this case we would set it up in 'onBootstrap' method
        // and attach it to the MvcEvent::EVENT_ROUTE
        /*$phpSettings = $event->getConfigListener()
            ->getMergedConfig(true)
            ->get('php_settings');*/
        $config = $event->getApplication()->getServiceManager()->get('Config');
        $phpSettings = (isset($config['php_settings'])) ? $config['php_settings'] : null;

        if ($phpSettings) {
            foreach ($phpSettings as $key => $value) {
                ini_set($key, $value);
            }
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
