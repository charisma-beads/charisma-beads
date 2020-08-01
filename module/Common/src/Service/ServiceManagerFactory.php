<?php

namespace Common\Service;

use Laminas\Mvc\Service\AbstractPluginManagerFactory;


class ServiceManagerFactory extends AbstractPluginManagerFactory
{
    const PLUGIN_MANAGER_CLASS = ServiceManager::class;
}
