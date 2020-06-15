<?php

namespace Common\Options;

use Zend\Stdlib\AbstractOptions;


class AkismetOptions extends AbstractOptions
{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $blog;

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     * @return AkismetOptions
     */
    public function setApiKey(string $apiKey): AkismetOptions
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getBlog(): string
    {
        return $this->blog;
    }

    /**
     * @param string $blog
     * @return AkismetOptions
     */
    public function setBlog(string $blog): AkismetOptions
    {
        $this->blog = $blog;
        return $this;
    }
}