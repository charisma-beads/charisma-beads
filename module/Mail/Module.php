<?php

namespace Mail;

use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;

class Module implements
    ConsoleUsageProviderInterface,
    ConsoleBannerProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php'
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getConsoleUsage(Console $console)
    {
        return array(
            'mailqueue send' => 'send the next batch of mail in the mail queue',
        );
    }
    
    public function getConsoleBanner(Console $console){
        return
        "==------------------------------------------------------==\n" .
        "        Welcome to Mail ZF2 Console-enabled app           \n" .
        "==------------------------------------------------------==\n" .
        "Version 1.0\n"
            ;
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getControllerConfig()
    {
        return include __DIR__ . '/config/controller.config.php';
    }
    
    public function getServiceConfig()
    {
        return include __DIR__ . '/config/service.config.php';
    }
}
