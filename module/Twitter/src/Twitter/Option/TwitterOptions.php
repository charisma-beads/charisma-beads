<?php

declare(strict_types=1);

namespace Twitter\Option;

use Twitter\Model\Tweet;
use Zend\Cache\Storage\Adapter\Filesystem;
use Zend\Http\Client\Adapter\Curl;
use Zend\Stdlib\AbstractOptions;

class TwitterOptions extends AbstractOptions
{
    protected $oauthOptions = [
        'access_token' => [
            'token' => '',
            'secret' => '',
        ],
        'oauth_options' => [
            'consumerKey' => '',
            'consumerSecret' => '',
        ],
        'http_client_options' => [
            'adapter' => Curl::class,
        ],
    ];

    protected $entityClass = Tweet::class;

    protected $screenName   = '';

    protected $username = '';

    protected $displayLimit = 4;

    protected $showDirectTweets = false;

    protected $showRetweets = true;

    protected $showTweetLinks = true;

    protected $showProfilePic = true;

    protected $cache = [
        'adapter' => [
            'name' => Filesystem::class,
            'options' => [
                'ttl'                   => 60*60, // one hour
                'dirLevel'              => 0,
                'cacheDir'              => './data/cache',
                'dirPermission'         => '700',
                'filePermission'        => '600',
            ],
        ],
        'plugins' => ['Serializer'],
    ];

    /**
     * @return array
     */
    public function getOauthOptions(): array
    {
        return $this->oauthOptions;
    }

    /**
     * @param array $oauthOptions
     * @return TwitterOptions
     */
    public function setOauthOptions(array $oauthOptions): TwitterOptions
    {
        $this->oauthOptions = array_merge($this->oauthOptions, $oauthOptions);
        return $this;
    }

    /**
     * @return string
     */
    public function getEntityClass(): string
    {
        return $this->entityClass;
    }

    /**
     * @param string $entityClass
     * @return TwitterOptions
     */
    public function setEntityClass(string $entityClass): TwitterOptions
    {
        $this->entityClass = $entityClass;
        return $this;
    }

    /**
     * @return string
     */
    public function getScreenName(): string
    {
        return $this->screenName;
    }

    /**
     * @param string $screenName
     * @return TwitterOptions
     */
    public function setScreenName(string $screenName): TwitterOptions
    {
        $this->screenName = $screenName;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return TwitterOptions
     */
    public function setUsername(string $username): TwitterOptions
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return int
     */
    public function getDisplayLimit(): int
    {
        return $this->displayLimit;
    }

    /**
     * @param int $displayLimit
     * @return TwitterOptions
     */
    public function setDisplayLimit(int $displayLimit): TwitterOptions
    {
        $this->displayLimit = $displayLimit;
        return $this;
    }

    /**
     * @return bool
     */
    public function isShowDirectTweets(): bool
    {
        return $this->showDirectTweets;
    }

    /**
     * @return bool
     */
    public function getShowDirectTweets(): bool
    {
        return $this->showDirectTweets;
    }

    /**
     * @param bool $showDirectTweets
     * @return TwitterOptions
     */
    public function setShowDirectTweets(bool $showDirectTweets): TwitterOptions
    {
        $this->showDirectTweets = $showDirectTweets;
        return $this;
    }

    /**
     * @return bool
     */
    public function getShowRetweets(): bool
    {
        return $this->showRetweets;
    }

    /**
     * @return bool
     */
    public function isShowRetweets(): bool
    {
        return $this->showRetweets;
    }

    /**
     * @param bool $showRetweets
     * @return TwitterOptions
     */
    public function setShowRetweets(bool $showRetweets): TwitterOptions
    {
        $this->showRetweets = $showRetweets;
        return $this;
    }

    /**
     * @return bool
     */
    public function isShowTweetLinks(): bool
    {
        return $this->showTweetLinks;
    }

    /**
     * @return bool
     */
    public function getShowTweetLinks(): bool
    {
        return $this->showTweetLinks;
    }

    /**
     * @param bool $showTweetLinks
     * @return TwitterOptions
     */
    public function setShowTweetLinks(bool $showTweetLinks): TwitterOptions
    {
        $this->showTweetLinks = $showTweetLinks;
        return $this;
    }

    /**
     * @return bool
     */
    public function isShowProfilePic(): bool
    {
        return $this->showProfilePic;
    }

    /**
     * @return bool
     */
    public function getShowProfilePic(): bool
    {
        return $this->showProfilePic;
    }

    /**
     * @param bool $showProfilePic
     * @return TwitterOptions
     */
    public function setShowProfilePic(bool $showProfilePic): TwitterOptions
    {
        $this->showProfilePic = $showProfilePic;
        return $this;
    }

    /**
     * @return array
     */
    public function getCache(): array
    {
        return $this->cache;
    }

    /**
     * @param array $cache
     * @return TwitterOptions
     */
    public function setCache(array $cache): TwitterOptions
    {
        $this->cache = $cache;
        return $this;
    }
}
