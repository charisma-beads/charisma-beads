<?php

namespace ThemeManager\View;

use Common\Stdlib\StringUtils;
use Common\View\AbstractViewHelper;


class SocialLinks extends AbstractViewHelper
{
    /**
     * @var array
     */
    protected $attributes = [
        'class' => 'social fa fa-%s',
        'title' => '%s',
    ];

    /**
     * @var string
     */
    protected $template = '<a href="%s" %s>%s</a>';

    /**
     * @var string
     */
    protected $iconElement = '';

    /**
     * @param null|array $attributes
     * @return string
     */
    public function __invoke(array $attributes = null)
    {
        if ($attributes) {
            $this->setAttributes($attributes);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        $html       = '';
        $socialLinks = $this->getView()->themeOptions('social_links');

        if (!empty($socialLinks)) {
            $links = $socialLinks;

            foreach ($links as $key => $value) {

                if (!$value) continue;

                $attributes = '';

                if (!StringUtils::startsWith($value, 'http')) {
                    $value = $this->getView()->url($value);
                }

                foreach($this->getAttributes() as $attr => $val) {
                    $attributes .= $attr . '="' . sprintf($val, $key) . '" ';
                }

                $html .= sprintf($this->getTemplate(), $value, $attributes, sprintf($this->getIconElement(), $key)) . PHP_EOL;
            }
        }

        return $html;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param array $class
     * @return $this
     */
    public function setAttributes(array $class)
    {
        $this->attributes = array_merge($this->attributes, $class);
        return $this;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param $template
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * @return string
     */
    public function getIconElement()
    {
        return $this->iconElement;
    }

    /**
     * @param $iconElement
     * @return $this
     */
    public function setIconElement($iconElement)
    {
        $this->iconElement = $iconElement;
        return $this;
    }
} 