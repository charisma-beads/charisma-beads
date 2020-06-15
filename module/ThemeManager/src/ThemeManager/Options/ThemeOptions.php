<?php

declare(strict_types=1);

namespace ThemeManager\Options;

use Zend\Stdlib\AbstractOptions;


class ThemeOptions extends AbstractOptions
{
    /**
     * @var string
     */
    protected $siteName;

    /**
     * @var string
     */
    protected $defaultTheme = 'default';

    /**
     * @var string
     */
    protected $adminTheme = 'default';

    /**
     * @var string
     */
    protected $themePath = './themes';

    /**
     * @var string
     */
    protected $publicDir = './public';

    /**
     * @var bool
     */
    protected $bootstrap = true;

    /**
     * @var string
     */
    protected $bootswatchTheme;

    /**
     * @var bool
     */
    protected $fontAwesome = true;

    /**
     * @var bool
     */
    protected $jqueryUi = false;

    /**
     * @var bool
     */
    protected $cache = false;

    /**
     * @var bool
     */
    protected $compressJavascript = false;

    /**
     * @var bool
     */
    protected $compressCss = false;

    /**
     * @var array
     */
    protected $socialLinks;

    /**
     * @return string
     */
    public function getSiteName()
    {
        return $this->siteName;
    }

    /**
     * @param string $siteName
     * @return ThemeOptions
     */
    public function setSiteName($siteName)
    {
        $this->siteName = $siteName;
        return $this;
    }

    /**
     * @return string $defaultTheme
     */
    public function getDefaultTheme()
    {
        return $this->defaultTheme;
    }

    /**
     * @param string $defaultTheme
     * @return \ThemeManager\Options\ThemeOptions
     */
    public function setDefaultTheme($defaultTheme)
    {
        $this->defaultTheme = $defaultTheme;
        return $this;
    }

    /**
     * @return string $adminTheme
     */
    public function getAdminTheme()
    {
        return $this->adminTheme;
    }

    /**
     * @param string $adminTheme
     * @return \ThemeManager\Options\ThemeOptions
     */
    public function setAdminTheme($adminTheme)
    {
        $this->adminTheme = $adminTheme;
        return $this;
    }

    /**
     * @return string $themePath
     */
    public function getThemePath()
    {
        return $this->themePath;
    }

    /**
     * @param string $themePath
     * @return \ThemeManager\Options\ThemeOptions
     */
    public function setThemePath($themePath)
    {
        $this->themePath = $themePath;
        return $this;
    }

    /**
     * @return string
     */
    public function getPublicDir()
    {
        return $this->publicDir;
    }

    /**
     * @param string $publicDir
     * @return ThemeOptions
     */
    public function setPublicDir(string $publicDir)
    {
        $this->publicDir = $publicDir;
        return $this;
    }

    /**
     * @return bool $bootstrap
     */
    public function getBootstrap()
    {
        return $this->bootstrap;
    }

    /**
     * @param $bootstrap
     * @return $this
     */
    public function setBootstrap($bootstrap)
    {
        $this->bootstrap = $bootstrap;
        return $this;
    }

    /**
     * @return string $bootswatchTheme
     */
    public function getBootswatchTheme()
    {
        return $this->bootswatchTheme;
    }

    /**
     * @param $bootswatchTheme
     * @return $this
     */
    public function setBootswatchTheme($bootswatchTheme)
    {
        $this->bootswatchTheme = $bootswatchTheme;
        return $this;
    }

    /**
     * @return bool $fontAwesome
     */
    public function getFontAwesome()
    {
        return $this->fontAwesome;
    }

    /**
     * @param $fontAwesome
     * @return $this
     */
    public function setFontAwesome($fontAwesome)
    {
        $this->fontAwesome = $fontAwesome;
        return $this;
    }

    /**
     * @return bool
     */
    public function getJqueryUi()
    {
        return $this->jqueryUi;
    }

    /**
     * @param $jqueryUi
     * @return $this
     */
    public function setJqueryUi($jqueryUi)
    {
        $this->jqueryUi = $jqueryUi;
        return $this;
    }

    /**
     * @return bool
     */
    public function getCache(): bool
    {
        return $this->cache;
    }

    /**
     * @param bool $cache
     * @return ThemeOptions
     */
    public function setCache(bool $cache): ThemeOptions
    {
        $this->cache = $cache;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCompressJavascript(): bool
    {
        return $this->compressJavascript;
    }

    /**
     * @param bool $compressJavascript
     * @return ThemeOptions
     */
    public function setCompressJavascript(bool $compressJavascript): ThemeOptions
    {
        $this->compressJavascript = $compressJavascript;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCompressCss(): bool
    {
        return $this->compressCss;
    }

    /**
     * @param bool $compressCss
     * @return ThemeOptions
     */
    public function setCompressCss(bool $compressCss): ThemeOptions
    {
        $this->compressCss = $compressCss;
        return $this;
    }

    /**
     * @return array
     */
    public function getSocialLinks()
    {
        return $this->socialLinks;
    }

    /**
     * @param array|SocialLinksOptions $socialLinks
     * @return $this
     */
    public function setSocialLinks($socialLinks)
    {
        if ($socialLinks instanceof SocialLinksOptions) {
            $socialLinks = $socialLinks->toArray();
        }

        $this->socialLinks = $socialLinks;
        return $this;
    }

}
