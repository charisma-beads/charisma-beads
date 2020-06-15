<?php

namespace Twitter\Model;

use DateTime;


class Tweet
{
    /**
     * @var DateTime
     */
    protected $time;

    /**
     * @var int
     */
    protected $idStr;

    /**
     * @var int
     */
    protected $userId;

    /**
     * @var string
     */
    protected $userName;

    /**
     * @var string
     */
    protected $screenName;

    /**
     * @var string
     */
    protected $profileImage;

    /**
     * @var bool
     */
    protected $verified;

    /**
     * @var int
     */
    protected $retweetCount;

    /**
     * @var int
     */
    protected $favoriteCount;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var \Twitter\Model\Tweet
     */
    protected $retweetStatus;

    /**
     * @var object
     */
    protected $entities;

    /**
     * @return boolean
     */
    public function isDirect()
    {
        return (substr($this->getText(false), 0, 1) == '@') ? true : false;
    }

    /**
     * @param bool $showTweetLinks
     * @return string
     */
    public function getText($showTweetLinks = true)
    {
        if ($this->isRetweet()) {
            return $this->getRetweetStatus()->getText();
        }

        return ($showTweetLinks) ? $this->formatLinks($this->text) : $this->text;
    }

    /**
     * @param $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isRetweet()
    {
        $retweet = $this->getRetweetStatus();
        return ($retweet) ? true : false;
    }

    /**
     * @return Tweet
     */
    public function getRetweetStatus()
    {
        return $this->retweetStatus;
    }

    /**
     * @param Tweet $retweetStatus
     * @return $this
     */
    public function setRetweetStatus(Tweet $retweetStatus)
    {
        $this->retweetStatus = $retweetStatus;
        return $this;
    }

    /**
     * @param string $text
     * @return string
     */
    public function formatLinks($text)
    {
        //Add link to all http:// links within tweets
        foreach ($this->getEntities('urls') as $url) {
            $link = '<a href="' . $url->url . '" target="_blank" title="' . $url->expanded_url . '">' . $url->url . '</a>';
            $text = str_replace($url->url, $link, $text);
        }

        //Add link to @usernames used within tweets
        foreach ($this->getEntities('user_mentions') as $mention) {
            $link = '<a href="http://twitter.com/' . $mention->screen_name . '" target="_blank" title="@' . $mention->name . '">@' . $mention->screen_name . '</a>';
            $text = str_replace('@' . $mention->screen_name, $link, $text);
        }

        //Add link to #hastags used within tweets
        foreach ($this->getEntities('hashtags') as $hashtag) {
            $link = '<a href="http://twitter.com/search?q=' . $hashtag->text . '" target="_blank" title="#' . $hashtag->text . '">#' . $hashtag->text . '</a>';
            $text = str_replace('#' . $hashtag->text, $link, $text);
        }

        return $text;
    }

    /**
     * @param string $which
     * @return array:
     */
    public function getEntities($which)
    {
        if ($this->isRetweet()) {
            return $this->getRetweetStatus()->getEntities($which);
        }

        $entity = (isset($this->entities->$which)) ? $this->entities->$which : array();

        return $entity;
    }

    /**
     * @param object $entities
     * @return \Twitter\Model\Tweet
     */
    public function setEntities($entities)
    {
        $this->entities = $entities;
        return $this;
    }

    /**
     * @return string
     */
    public function reweetedBy()
    {
        return $this->userName;
    }

    /**
     * @return string
     */
    public function getTimePostedShort()
    {
        return $this->getTime('d M');
    }

    /**
     * @param string $format
     * @return string
     */
    public function getTime($format = null)
    {
        $format = ($format) ? $format : DateTime::W3C;

        if ($this->isRetweet()) {
            $time = $this->getRetweetStatus()->getTime($format);
        } else {
            $time = $this->time->format($format);
        }

        return $time;
    }

    /**
     * @param string $time
     * @return \Twitter\Model\Tweet
     */
    public function setTime($time)
    {
        $this->time = new DateTime($time);
        return $this;
    }

    /**
     * @return string
     */
    public function getRelativeTime()
    {
        $now = new DateTime();
        $delta = $now->format('U') - $this->getTime('U');

        if ($delta < 60) {
            $relative = '1m';
        } else if ($delta < 120) {
            $relative = '1m';
        } else if ($delta < (60 * 60)) {
            $relative = round($delta / 60) . 'm';
        } else if ($delta < (120 * 60)) {
            $relative = '1h';
        } else if ($delta < (24 * 60 * 60)) {
            $relative = round($delta / 3600) . 'h';
        } else if ($delta < (48 * 60 * 60)) {
            return '1 day';
            //$relative = $this->getTime('d M');
        } else {
            $relative = $this->getTime('d M');
        }

        return $relative;
    }

    /**
     * @return int
     */
    public function getIdStr()
    {
        if ($this->isRetweet()) {
            return $this->getRetweetStatus()->getIdStr();
        }

        return $this->idStr;
    }

    /**
     * @param int $idStr
     * @return \Twitter\Model\Tweet
     */
    public function setIdStr($idStr)
    {
        $this->idStr = $idStr;
        return $this;
    }

    /**
     * @param bool|false $parent
     * @return int
     */
    public function getUserId($parent = false)
    {
        if ($this->isRetweet() && !$parent) {
            return $this->getRetweetStatus()->getUserId();
        }

        return $this->userId;
    }

    /**
     * @param int $userId
     * @return \Twitter\Model\Tweet
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @param bool|false $parent
     * @return string
     */
    public function getUserName($parent = false)
    {
        if ($this->isRetweet() && !$parent) {
            return $this->getRetweetStatus()->getUserName();
        }

        return $this->userName;
    }

    /**
     * @param string $userName
     * @return \Twitter\Model\Tweet
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
        return $this;
    }

    /**
     * @param bool|false $parent
     * @return string
     */
    public function getScreenName($parent = false)
    {
        if ($this->isRetweet() && !$parent) {
            return $this->getRetweetStatus()->getScreenName();
        }

        return $this->screenName;
    }

    /**
     * @param string $screenName
     * @return \Twitter\Model\Tweet
     */
    public function setScreenName($screenName)
    {
        $this->screenName = $screenName;
        return $this;
    }

    /**
     * @return string
     */
    public function getProfileImage()
    {
        if ($this->isRetweet()) {
            return $this->getRetweetStatus()->getProfileImage();
        }

        return $this->profileImage;
    }

    /**
     * @param string $profileImage
     * @return \Twitter\Model\Tweet
     */
    public function setProfileImage($profileImage)
    {
        $this->profileImage = $profileImage;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getVerified()
    {
        if ($this->isRetweet()) {
            return $this->getRetweetStatus()->getVerified();
        }

        return $this->verified;
    }

    /**
     * @param bool $verified
     * @return \Twitter\Model\Tweet
     */
    public function setVerified($verified)
    {
        $this->verified = $verified;
        return $this;
    }

    /**
     * @return number
     */
    public function getRetweetCount()
    {
        if ($this->isRetweet()) {
            return $this->getRetweetStatus()->getRetweetCount();
        }

        return $this->retweetCount;
    }

    /**
     * @param int $retweetCount
     * @return \Twitter\Model\Tweet
     */
    public function setRetweetCount($retweetCount)
    {
        $this->retweetCount = $retweetCount;
        return $this;
    }

    /**
     * @return int
     */
    public function getFavoriteCount()
    {
        if ($this->isRetweet()) {
            return $this->getRetweetStatus()->getFavoriteCount();
        }

        return $this->favoriteCount;
    }

    /**
     * @param int $favoriteCount
     * @return \Twitter\Model\Tweet
     */
    public function setFavoriteCount($favoriteCount)
    {
        $this->favoriteCount = $favoriteCount;
        return $this;
    }
}
