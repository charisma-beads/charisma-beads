<?php

namespace ThemeManager\Model;

use Common\Model\Model;
use Common\Model\ModelInterface;

class WidgetModel implements ModelInterface
{
    use Model,
        WidgetParamsTrait;

    /**
     * @var int
     */
    protected $widgetId;

    /**
     * @var int
     */
    protected $widgetGroupId;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $widget;

    /**
     * @var int
     */
    protected $sortOrder;

    /**
     * @var bool
     */
    protected $showTitle;


    /**
     * @var string
     */
    protected $html;

    /**
     * @var bool
     */
    protected $enabled;

    /**
     * @var WidgetGroupModel
     */
    protected $group;

    /**
     * @return int
     */
    public function getWidgetId()
    {
        return $this->widgetId;
    }

    /**
     * @param int $widgetId
     * @return WidgetModel
     */
    public function setWidgetId($widgetId)
    {
        $this->widgetId = $widgetId;
        return $this;
    }

    /**
     * @return int
     */
    public function getWidgetGroupId()
    {
        return $this->widgetGroupId;
    }

    /**
     * @param int $widgetGroupId
     * @return WidgetModel
     */
    public function setWidgetGroupId($widgetGroupId)
    {
        $this->widgetGroupId = $widgetGroupId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return WidgetModel
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return WidgetModel
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getWidget()
    {
        return $this->widget;
    }

    /**
     * @param string $widget
     * @return WidgetModel
     */
    public function setWidget($widget)
    {
        $this->widget = $widget;
        return $this;
    }

    /**
     * @return int
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * @param int $sortOrder
     * @return WidgetModel
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }

    /**
     * @return bool
     */
    public function isShowTitle()
    {
        return $this->showTitle;
    }

    /**
     * @param bool $showTitle
     * @return WidgetModel
     */
    public function setShowTitle($showTitle)
    {
        $this->showTitle = $showTitle;
        return $this;
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * @param string $html
     * @return WidgetModel
     */
    public function setHtml($html)
    {
        $this->html = $html;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     * @return WidgetModel
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * @return WidgetGroupModel
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param WidgetGroupModel $group
     * @return WidgetModel
     */
    public function setGroup($group)
    {
        $this->group = $group;
        return $this;
    }
}
