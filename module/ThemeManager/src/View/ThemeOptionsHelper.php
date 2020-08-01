<?php

namespace ThemeManager\View;

use Common\View\AbstractViewHelper;
use ThemeManager\Options\ThemeOptions;
use Laminas\Config\Config;


class ThemeOptionsHelper extends AbstractViewHelper
{
    /**
     * @var ThemeOptions
     */
    protected $themeOptions;

    public function __invoke($key)
    {
        $this->getOptions();

        if (is_string($key)) {
            return $this->get($key);
        }

        return $this;
    }

    /**
     * @param $key
     * @return Config|string|null
     */
    public function get($key)
    {
        $returnValue = null;

        if (isset($this->getOptions()->$key)) {
            $returnValue = $this->getOptions()->$key;
        }

        return $returnValue;
    }

    /**
     * @param ThemeOptions $options
     * @return $this
     */
    public function setOptions(ThemeOptions $options)
    {
        $this->themeOptions = $options;
        return $this;
    }

    /**
     * @return ThemeOptions
     */
    public function getOptions()
    {
        if (!$this->themeOptions instanceof ThemeOptions) {
            $options = $this->getServiceLocator()
                ->getServiceLocator()
                ->get(ThemeOptions::class);
            $this->setOptions($options);
        }

        return $this->themeOptions;
    }
} 