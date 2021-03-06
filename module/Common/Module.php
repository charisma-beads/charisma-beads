<?php

namespace Common;

// need as autoloader not loaded at this point
require_once(__DIR__ . '/src/Config/ConfigInterface.php');
require_once(__DIR__ . '/src/Config/ConfigTrait.php');

use Common\Config\ConfigInterface;
use Common\Config\ConfigTrait;
use Common\Event\ConfigListener;
use Common\Event\MvcListener;
use Common\Event\TidyResponseSender;
use Common\Event\ServiceListener;
use Common\Mapper\MapperInterface;
use Common\Mapper\MapperManager;
use Common\Model\ModelInterface;
use Common\Model\ModelManager;
use Common\Service\ServiceInterface;
use Common\Service\ServiceManager;
use Laminas\Console\Adapter\AdapterInterface as Console;
use Laminas\Http\Request;
use Laminas\ModuleManager\Feature\ConsoleBannerProviderInterface;
use Laminas\ModuleManager\ModuleManager;
use Laminas\Mvc\MvcEvent;
use Laminas\Mvc\ResponseSender\SendResponseEvent;

/**
 * Class Module
 *
 * @package Common
 */
class Module implements ConsoleBannerProviderInterface, ConfigInterface
{
    use ConfigTrait;

    /**
     * @param ModuleManager $moduleManager
     */
    public function init(ModuleManager $moduleManager)
    {
        /* @var $sm \Laminas\ServiceManager\ServiceManager */
        $sm = $moduleManager->getEvent()->getParam('ServiceManager');
        $serviceListener = $sm->get('ServiceListener');
        $events = $moduleManager->getEventManager();

        $serviceListener->addServiceManager(
            MapperManager::class,
            'uthando_mappers',
            MapperInterface::class,
            'getUthandoMapperConfig'
        );

        $serviceListener->addServiceManager(
            ModelManager::class,
            'uthando_models',
            ModelInterface::class,
            'getUthandoModelConfig'
        );

        $serviceListener->addServiceManager(
            ServiceManager::class,
            'uthando_services',
            ServiceInterface::class,
            'getUthandoServiceConfig'
        );

        $events->attach(new ConfigListener());
    }

    /**
     * @param MvcEvent $event
     */
    public function onBootstrap(MvcEvent $event)
    {
        $app = $event->getApplication();
        $eventManager = $app->getEventManager();

        $eventManager->attach(new MvcListener());
        $eventManager->attach(new ServiceListener());

        if ($event->getRequest() instanceof Request) {
            $config = $app->getServiceManager()
                ->get('config');

            $tidyConfig = (isset($config['tidy'])) ? $config['tidy'] : ['enable' => false];

            if ($tidyConfig['enable']) {
                $eventManager->getSharedManager()->attach(
                    'Laminas\Mvc\SendResponseListener',
                    SendResponseEvent::EVENT_SEND_RESPONSE,
                    new TidyResponseSender($tidyConfig['config'], $event->getRequest()->isXmlHttpRequest())
                );
            }
        }
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @param Console $console
     * @return string
     */
    public function getConsoleBanner(Console $console)
    {
        return
            "==-------------------------------------------------------==\n" .
            "        Welcome to Uthando CMS Console-enabled app         \n" .
            "==-------------------------------------------------------==\n" .
            "Version 1.0\n";
    }
}
