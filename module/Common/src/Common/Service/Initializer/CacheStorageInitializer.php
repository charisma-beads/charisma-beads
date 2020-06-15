<?php

namespace Common\Service\Initializer;

use Common\Options\CacheOptions;
use Zend\Cache\Storage\Adapter\AbstractAdapter;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Common\Cache\CacheStorageAwareInterface;

class CacheStorageInitializer implements InitializerInterface
{
    /**
     * @param $instance
     * @param ServiceLocatorInterface $serviceLocator
     * @return void
     */
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        if ($instance instanceof CacheStorageAwareInterface ) {

            $cacheOptions = $serviceLocator->get(CacheOptions::class);

            if ($cacheOptions instanceof CacheOptions && $cacheOptions->isEnabled()) {

                $adapter = $cacheOptions->getAdapter();
                $cache = new $adapter;

                $cache->setOptions($cacheOptions->getOptions()->toArray());

                foreach ($cacheOptions->getPlugins() as $plugin) {
                    $pluginClass = new $plugin;
                    $cache->addPlugin($pluginClass);
                }
                $instance->setCache($cache);
            }
        }
    }
}
