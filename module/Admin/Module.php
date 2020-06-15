<?php

namespace Admin;

use Common\Config\ConfigInterface;
use Common\Config\ConfigTrait;

/**
 * Class Module
 *
 * @package Admin
 */
class Module implements ConfigInterface
{
    use ConfigTrait;

    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\ClassMapAutoloader' => [
                __DIR__ . '/autoload_classmap.php'
            ],
        ];
    }
}

