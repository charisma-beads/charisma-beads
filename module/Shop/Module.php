<?php

namespace Shop;

use Shop\Event\ControllerListener;
use Shop\Event\ErrorListener;
use Shop\Event\FileManagerListener;
use Shop\Event\SiteMapListener;
use Shop\Event\UserListener;
use Shop\Event\StockControlListener;
use Shop\Event\VoucherListener;
use Common\Config\ConfigInterface;
use Common\Config\ConfigTrait;
use Laminas\Console\Adapter\AdapterInterface as Console;
use Laminas\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Laminas\Mvc\MvcEvent;

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

        $eventManager->attach(new ControllerListener());
        $eventManager->attach(new FileManagerListener());
        $eventManager->attach(new SiteMapListener());
        $eventManager->attach(new UserListener());
        $eventManager->attach(new ErrorListener());
        $eventManager->attach(new StockControlListener());
        $eventManager->attach(new VoucherListener());
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
            'Laminas\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }
}
