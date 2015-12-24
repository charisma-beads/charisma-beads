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

use Shop\Event\ControllerListener;
use Shop\Event\FileManagerListener;
use Shop\Event\SiteMapListener;
use Shop\Event\UserListener;
use UthandoCommon\Config\ConfigInterface;
use UthandoCommon\Config\ConfigTrait;
use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ArrayUtils;

/**
 * Class Module
 *
 * @package Shop
 */
class Module implements ConsoleUsageProviderInterface, ConfigInterface
{
    use ConfigTrait;

    public function onBootStrap(MvcEvent $e)
    {
        $app = $e->getApplication();
        $eventManager = $app->getEventManager();

        $eventManager->attachAggregate(new ControllerListener());
        $eventManager->attachAggregate(new FileManagerListener());
        $eventManager->attachAggregate(new SiteMapListener());
        $eventManager->attachAggregate(new UserListener());
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
