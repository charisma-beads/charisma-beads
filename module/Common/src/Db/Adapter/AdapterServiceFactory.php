<?php

namespace Common\Db\Adapter;

use Common\Options\DbOptions;
use Laminas\Db\Adapter\Adapter;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;


class AdapterServiceFactory implements FactoryInterface
{
    /**
     * Create db adapter service
     *
     * @param ServiceLocatorInterface $container
     * @return Adapter
     */
    public function createService(ServiceLocatorInterface $container)
    {
        $config = $container->get(DbOptions::class);
        return new Adapter($config->toArray());
    }
}
