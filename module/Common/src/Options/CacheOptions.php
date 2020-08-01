<?php

namespace Common\Options;

use Laminas\Cache\Storage\Adapter\AdapterOptions;
use Laminas\Cache\Storage\Adapter\Filesystem;
use Laminas\Cache\Storage\Adapter\FilesystemOptions;
use Laminas\Cache\Storage\Plugin\Serializer;
use Laminas\Stdlib\AbstractOptions;


class CacheOptions extends AbstractOptions
{
    /**
     * @var array
     */
    public static $adapterOptionsMap = [
        Filesystem::class => FilesystemOptions::class,
    ];

    protected $enabled = false;

    /**
     * @var string
     */
    protected $adapter = Filesystem::class;

    /**
     * @var AdapterOptions
     */
    protected $options;

    /**
     * @var array
     */
    protected $plugins = [
        Serializer::class,
    ];

    public function getAdapterOptions($options): AdapterOptions
    {
        /** @var AdapterOptions $adapterOptions */
        $adapterOptions = new self::$adapterOptionsMap[$this->getAdapter()];
        $adapterOptions->setFromArray($options);

        return $adapterOptions;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function getEnabled(): bool
    {
        return $this->isEnabled();
    }

    public function setEnabled(bool $enabled): CacheOptions
    {
        $this->enabled = $enabled;
        return $this;
    }

    public function getAdapter(): string
    {
        return $this->adapter;
    }

    public function setAdapter(string $adapter): CacheOptions
    {
        $this->adapter = $adapter;
        return $this;
    }

    public function getOptions(): AdapterOptions
    {
        return $this->options;
    }

    public function setOptions(array $options): CacheOptions
    {
        $optionsClass = $this->getAdapterOptions($options);
        $this->options = $optionsClass;
        return $this;
    }

    public function getPlugins(): array
    {
        return $this->plugins;
    }

    public function setPlugins(array $plugins): CacheOptions
    {
        $this->plugins = $plugins;
        return $this;
    }

    public function toArray()
    {
        $array = parent::toArray();
        $returnArray = [];

        foreach ($array as $key => $value) {

            if ($value instanceof AbstractOptions) {
                $returnArray[$key] = $value->toArray();
            } else {
                $returnArray[$key] = $value;
            }
        }

        return $returnArray;
    }
}
