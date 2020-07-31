<?php

namespace Common\Model;

use Laminas\Mvc\Service\AbstractPluginManagerFactory;


class ModelManagerFactory extends AbstractPluginManagerFactory
{
    const PLUGIN_MANAGER_CLASS = ModelManager::class;
}
