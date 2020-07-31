<?php

declare(strict_types=1);

namespace ThemeManager\View;

use Common\Service\ServiceManager;
use ThemeManager\Service\WidgetGroupManager;
use Laminas\ServiceManager\AbstractPluginManager;

/**
 * Trait GroupServiceTrait
 * @package ThemeManager\Service
 * @method AbstractPluginManager getServiceLocator()
 */
trait WidgetGroupServiceTrait
{
    /**
     * @var WidgetGroupManager
     */
    protected $widgetGroupManager;

    protected function getWidgetGroupService(): WidgetGroupManager
    {
        if (!$this->widgetGroupManager instanceof WidgetGroupManager) {
            $widgetGroupManager = $this->getServiceLocator()
                ->getServiceLocator()
                ->get(ServiceManager::class)
                ->get(WidgetGroupManager::class);
            $this->widgetGroupManager = $widgetGroupManager;
        }

        return $this->widgetGroupManager;
    }
}
