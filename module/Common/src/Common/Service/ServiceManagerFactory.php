<?php

namespace Common\Service;

use Zend\Mvc\Service\AbstractPluginManagerFactory;


class ServiceManagerFactory extends AbstractPluginManagerFactory
{
    const PLUGIN_MANAGER_CLASS = ServiceManager::class;
}
