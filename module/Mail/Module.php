<?php

namespace Mail;

use Common\Config\ConfigInterface;
use Common\Config\ConfigTrait;
use Mail\Event\MailListener;
use Laminas\Console\Adapter\AdapterInterface as Console;
use Laminas\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Laminas\Mvc\MvcEvent;


class Module implements ConsoleUsageProviderInterface, ConfigInterface
{
    use ConfigTrait;

    /**
     * @param MvcEvent $event
     */
    public function onBootstrap(MvcEvent $event)
    {
        $app = $event->getApplication();
        $eventManager = $app->getEventManager();

        $eventManager->attach(new MailListener());
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @param Console $console
     * @return array
     */
    public function getConsoleUsage(Console $console)
    {
        return [
            'mailqueue send' => 'send the next batch of mail in the mail queue',
        ];
    }
}
