<?php

declare(strict_types=1);

namespace SessionManager\Options;

use Zend\Session\Config\SessionConfig;
use Zend\Session\Storage\SessionArrayStorage;
use Zend\Session\Validator\HttpUserAgent;
use Zend\Session\Validator\RemoteAddr;
use Zend\Stdlib\AbstractOptions;

class SessionOptions extends AbstractOptions
{
    /**
     * @var string
     */
    protected $sessionConfigClass = SessionConfig::class;

    /**
     * @var string
     */
    protected $storage = SessionArrayStorage::class;

    /**
     * @var string|null
     */
    protected $saveHandler;

    /**
     * @var array
     */
    protected $validators = [
        RemoteAddr::class,
        HttpUserAgent::class,
    ];

    /**
     * @return string
     */
    public function getSessionConfigClass(): string
    {
        return $this->sessionConfigClass;
    }

    /**
     * @param string $sessionConfigClass
     * @return SessionOptions
     */
    public function setSessionConfigClass(string $sessionConfigClass): SessionOptions
    {
        $this->sessionConfigClass = $sessionConfigClass;
        return $this;
    }

    /**
     * @return string
     */
    public function getStorage(): string
    {
        return $this->storage;
    }

    /**
     * @param string $storage
     * @return SessionOptions
     */
    public function setStorage(string $storage): SessionOptions
    {
        $this->storage = $storage;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSaveHandler(): ?string
    {
        return $this->saveHandler;
    }

    /**
     * @param string $saveHandler
     * @return SessionOptions
     */
    public function setSaveHandler(?string $saveHandler): SessionOptions
    {
        if ('files' === $saveHandler) $saveHandler = null;
        $this->saveHandler = $saveHandler;
        return $this;
    }

    /**
     * @return array
     */
    public function getValidators(): array
    {
        return $this->validators;
    }

    /**
     * @param array $validators
     * @return SessionOptions
     */
    public function setValidators(array $validators): SessionOptions
    {
        $this->validators = $validators;
        return $this;
    }
}