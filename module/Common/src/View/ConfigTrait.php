<?php

namespace Common\View;

use Laminas\ServiceManager\ServiceLocatorAwareTrait;
use Laminas\Stdlib\Exception\InvalidArgumentException;
use Laminas\View\HelperPluginManager;

/**
 * Class ConfigTrait
 *
 * @package Common\View
 * @method HelperPluginManager getServiceLocator()
 */
trait ConfigTrait
{
    use ServiceLocatorAwareTrait;

    /**
     * @var array
     */
    protected $config;

    /**
     * Gets the config options as an array, if a key is supplied then that keys options is returned.
     *
     * @param string $key
     * @return array|null
     * @throws array|InvalidArgumentException
     */
    protected function getConfig($key = null)
    {
        if ($this->config === null) {
            $this->setConfig();
        }

        if (null === $key) {
            return $this->config;
        }

        if (!array_key_exists($key, $this->config)) {
            throw new InvalidArgumentException("key: '" . $key . "' is not set in configuration options.");
        }

        return $this->config[$key];
    }

    /**
     * Sets the config array.
     *
     * @return AbstractViewHelper
     */
    protected function setConfig()
    {
        $this->config = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('config');
        return $this;
    }
}
