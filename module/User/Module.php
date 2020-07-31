<?php

namespace User;

use Common\Config\ConfigInterface;
use Common\Config\ConfigTrait;
use User\Event\MvcListener;
use Laminas\Console\Adapter\AdapterInterface as Console;
use Laminas\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Laminas\Mvc\MvcEvent;

class Module implements ConfigInterface, ConsoleUsageProviderInterface
{
    use ConfigTrait;

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
            'Laminas\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }


    public function getConsoleUsage(Console $console)
    {
        return [
            'user cleanup' => 'clean all non verified registrations.',
        ];
    }
}
