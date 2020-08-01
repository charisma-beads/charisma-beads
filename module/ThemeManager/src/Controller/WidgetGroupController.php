<?php

declare(strict_types=1);

namespace ThemeManager\Controller;

use Common\Controller\AbstractCrudController;
use ThemeManager\Service\WidgetGroupManager;

class WidgetGroupController extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'widgetGroupId'];
    protected $serviceName = WidgetGroupManager::class;
    protected $route = 'admin/theme-manager/widget-group';
    protected $routes = [];
}
