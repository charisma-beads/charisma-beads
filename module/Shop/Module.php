<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop;

use Shop\Event\ServiceListener;
use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ArrayUtils;

/**
 * Class Module
 *
 * @package Shop
 */
class Module implements ConsoleUsageProviderInterface
{
    public function init(ModuleManager $moduleManager)
    {
        $events = $moduleManager->getEventManager();

        // Registering a listener at default priority, 1, which will trigger
        // after the ConfigListener merges config.
        $events->attach(ModuleEvent::EVENT_MERGE_CONFIG, [$this, 'onMergeConfig']);
    }

    public function onBootStrap(MvcEvent $e)
    {
        $app = $e->getApplication();
        $eventManager = $app->getEventManager();
        
        $eventManager->attachAggregate(new ServiceListener());
    }

    public function onMergeConfig(ModuleEvent $e)
    {
        $configListener = $e->getConfigListener();
        $config = $configListener->getMergedConfig(false);

        // Modify the configuration;
        if (isset($config['load_uthando_configs']) && true === $config['load_uthando_configs']) {
            $routes = include __DIR__ . '/config/uthando-routes.config.php';
            $acl = include __DIR__ . '/config/uthando-user.config.php';
            $navigation = include __DIR__ . '/config/uthando-navigation.config.php';
            $shopConfig = array_merge($routes, $navigation, $acl);
            $config = ArrayUtils::merge($config, $shopConfig);
        }

        // Pass the changed configuration back to the listener:
        $configListener->setMergedConfig($config);
    }

    public function getConsoleUsage(Console $console)
    {
        return [
            'shopping-cart gc' => 'delete old and forgotten shopping carts in database',
        ];
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
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
}
