<?php

namespace Twitter;

use Common\Config\ConfigInterface;
use Common\Config\ConfigTrait;
use Twitter\Event\AutoPostListener;
use Zend\Mvc\MvcEvent;


class Module implements ConfigInterface
{
    use ConfigTrait;

    public function onBootStrap(MvcEvent $e)
    {
        $app            = $e->getApplication();
        $eventManager   = $app->getEventManager();
        $event          = new AutoPostListener();

        $event->attach($eventManager);
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
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }
}
