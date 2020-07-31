<?php

namespace ThemeManager;

use Common\Config\ConfigInterface;
use Common\Config\ConfigTrait;
use ThemeManager\Event\ConfigListener;
use Laminas\ModuleManager\ModuleManager;
use Laminas\Mvc\MvcEvent;
use ThemeManager\Event\MvcListener;

/**
 * Class Module
 *
 * @package ThemeManager
 */
class Module implements ConfigInterface
{
    use ConfigTrait;

    public function init(ModuleManager $moduleManager)
    {
        /* @var $sm \Laminas\ServiceManager\ServiceManager */
        $sm = $moduleManager->getEvent()->getParam('ServiceManager');
        $serviceListener = $sm->get('ServiceListener');
        $events = $moduleManager->getEventManager();
        $events->attach(new ConfigListener());
    }

    /**
     * @param MvcEvent $event
     */
    public function onBootstrap(MvcEvent $event)
    {
        $eventManager = $event->getApplication()->getEventManager();
        $eventManager->attach(new MvcListener());
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Laminas\Loader\ClassMapAutoloader' => [
                __DIR__ . '/autoload_classmap.php'
            ],
            'Laminas\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }
}
