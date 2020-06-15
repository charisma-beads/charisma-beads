<?php

namespace ThemeManager;

use Common\Config\ConfigInterface;
use Common\Config\ConfigTrait;
use ThemeManager\Event\ConfigListener;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent;
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
        /* @var $sm \Zend\ServiceManager\ServiceManager */
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
}
