<?php

namespace Common\Mapper;

use Laminas\Mvc\Service\AbstractPluginManagerFactory;


class MapperManagerFactory extends AbstractPluginManagerFactory
{
    const PLUGIN_MANAGER_CLASS = MapperManager::class;
}
