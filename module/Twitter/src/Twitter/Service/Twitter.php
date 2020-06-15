<?php

namespace Twitter\Service;

use Common\Cache\CacheStorageAwareInterface;
use Twitter\Model\TweetCollection;
use ZendService\Twitter\Response;
use ZendService\Twitter\Twitter as TwitterService;
use Common\Cache\CacheTrait;


class Twitter implements CacheStorageAwareInterface
{
    use CacheTrait;

    /**
     * @var TwitterService
     */
    protected $twitter;

    /**
     * @var array
     */
    protected $options;

    public function getUserTimeLine(string $screenName = '')
    {
        $response = $this->getCacheItem($screenName);

        if (!$response) {
            $response = $this->getTwitter()->statusesUserTimeline([
                'screen_name' => ($screenName) ? $screenName : $this->getOption('screen_name')
            ]);

            $this->setCacheItem($screenName, $response);
        }

        return $this->processTweets($response);
    }

    /**
     * @param $option
     * @return null
     */
    public function getOption($option)
    {
        if (!in_array($option, $this->options)) {
            return null;
        }

        return $this->options[$option];
    }

    /**
     * @param Response $response
     * @return array|TweetCollection
     */
    public function processTweets(Response $response)
    {
        if ($response->isSuccess()) {
            $tweets = new TweetCollection($response->toValue(), $this->getOptions());
        } else {
            $errors = $response->getErrors();
            $tweets = [
                'errors' => $errors,
            ];
        }

        return $tweets;
    }

    /**
     * @param string $string
     * @return Response
     */
    public function statusUpdate(string $string)
    {
        $service = $this->getTwitter();

        $response = $service->statusesUpdate($string);

        return $response;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    public function getTwitter(): TwitterService
    {
        return $this->twitter;
    }

    public function setTwitter(TwitterService $twitter): Twitter
    {
        $this->twitter = $twitter;
        return $this;
    }
}
