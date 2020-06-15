<?php

declare(strict_types=1);

namespace ThemeManager\Options;

use Zend\Stdlib\AbstractOptions;

class SocialLinksOptions extends AbstractOptions
{
    /**
     * @var string
     */
    protected $facebook;

    /**
     * @var string
     */
    protected $twitter;

    /**
     * @var string
     */
    protected $rss;

    /**
     * @return string
     */
    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    /**
     * @param string $facebook
     * @return SocialLinksOptions
     */
    public function setFacebook(?string $facebook): SocialLinksOptions
    {
        $this->facebook = $facebook;
        return $this;
    }

    /**
     * @return string
     */
    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    /**
     * @param string $twitter
     * @return SocialLinksOptions
     */
    public function setTwitter(?string $twitter): SocialLinksOptions
    {
        $this->twitter = $twitter;
        return $this;
    }

    /**
     * @return string
     */
    public function getRss(): ?string
    {
        return $this->rss;
    }

    /**
     * @param string $rss
     * @return SocialLinksOptions
     */
    public function setRss(string $rss): SocialLinksOptions
    {
        $this->rss = $rss;
        return $this;
    }
}
