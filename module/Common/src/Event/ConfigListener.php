<?php

namespace Common\Event;

use Common\Config\ConfigInterface;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\EventManager\ListenerAggregateTrait;
use Laminas\ModuleManager\ModuleEvent;
use Laminas\Stdlib\ArrayUtils;


class ConfigListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    /**
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(ModuleEvent::EVENT_MERGE_CONFIG, [$this, 'onMergeConfig'], 1);
    }

    /**
     * @param ModuleEvent $event
     * @return ConfigListener
     */
    public function onMergeConfig(ModuleEvent $event)
    {
        $configListener     = $event->getConfigListener();
        $config             = $configListener->getMergedConfig(false);
        $loadedModules      = $event->getTarget()->getLoadedModules();
        $loadUthandoConfigs = (isset($config['load_uthando_configs'])) ? $config['load_uthando_configs'] : false;
        $uthandoConfig      = [];

        if (false === $loadUthandoConfigs) return $this;

        // get the configurations from each module
        // must return an array to merge
        foreach ($loadedModules as $module) {
            if ($module instanceof ConfigInterface) {
                $moduleConfig = $module->getUthandoConfig();
                $uthandoConfig = ArrayUtils::merge($uthandoConfig, $moduleConfig);
            }
        }

        $config = ArrayUtils::merge($config, $uthandoConfig);

        // Pass the changed configuration back to the listener:
        $configListener->setMergedConfig($config);

        return $this;
    }
}
