<?php

namespace News;

use Common\Config\ConfigInterface;
use Common\Config\ConfigTrait;
use News\Event\SiteMapListener;
use Laminas\Mvc\MvcEvent;


class Module implements ConfigInterface
{
    use ConfigTrait;

    /**
     * @param MvcEvent $e
     */
    public function onBootStrap(MvcEvent $e)
    {
        $app = $e->getApplication();
        $eventManager = $app->getEventManager();

        $eventManager->attachAggregate(new SiteMapListener());
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
} 