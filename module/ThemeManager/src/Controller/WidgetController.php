<?php

declare(strict_types=1);

namespace ThemeManager\Controller;

use Common\Controller\AbstractCrudController;
use ThemeManager\Service\WidgetManager;

class WidgetController extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'widgetId'];
    protected $serviceName = WidgetManager::class;
    protected $route = 'admin/theme-manager/widget';
    protected $routes = [];
}
