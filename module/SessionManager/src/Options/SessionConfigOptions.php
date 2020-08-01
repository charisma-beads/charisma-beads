<?php

declare(strict_types=1);

namespace SessionManager\Options;

use Laminas\Stdlib\AbstractOptions;

class SessionConfigOptions extends AbstractOptions
{
    /**
     * @var int
     */
    protected $cookieLifetime = 86400;

    /**
     * @var string
     */
    protected $name = 'uthando-cms';

    /**
     * @var int
     */
    protected $rememberMeSeconds = 86400;

    /**
     * @var string
     */
    protected $savePath = './data/sessions';

    /**
     * @return int
     */
    public function getCookieLifetime(): int
    {
        return $this->cookieLifetime;
    }

    /**
     * @param int $cookieLifetime
     * @return SessionConfigOptions
     */
    public function setCookieLifetime(int $cookieLifetime): SessionConfigOptions
    {
        $this->cookieLifetime = $cookieLifetime;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return SessionConfigOptions
     */
    public function setName(string $name): SessionConfigOptions
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getRememberMeSeconds(): int
    {
        return $this->rememberMeSeconds;
    }

    /**
     * @param int $rememberMeSeconds
     * @return SessionConfigOptions
     */
    public function setRememberMeSeconds(int $rememberMeSeconds): SessionConfigOptions
    {
        $this->rememberMeSeconds = $rememberMeSeconds;
        return $this;
    }

    /**
     * @return string
     */
    public function getSavePath(): string
    {
        return $this->savePath;
    }

    /**
     * @param string $savePath
     * @return SessionConfigOptions
     */
    public function setSavePath(string $savePath): SessionConfigOptions
    {
        $this->savePath = $savePath;
        return $this;
    }
}