<?php

use ThemeManager\Controller\SettingsController;
use ThemeManager\Controller\WidgetController;
use ThemeManager\Controller\WidgetGroupController;
use ThemeManager\Options\ThemeOptions;
use ThemeManager\Service\ThemeOptionsFactory;
use ThemeManager\Service\WidgetGroupManager;
use ThemeManager\Service\WidgetManager;
use ThemeManager\View\BootStrapTheme;
use ThemeManager\View\SocialLinks;
use ThemeManager\View\ThemeOptionsHelper;
use ThemeManager\View\ThemePath;
use ThemeManager\View\WidgetHelper;
use ThemeManager\Widget\Html;
use ThemeManager\Widget\Content;
use ThemeManager\Widget\LayoutRow;
use ThemeManager\Widget\Partial;

return [
    'controllers' => [
        'invokables' => [
            SettingsController::class       => SettingsController::class,
            WidgetController::class         => WidgetController::class,
            WidgetGroupController::class    => WidgetGroupController::class,
        ],
    ],
    'uthando_services' => [
        'invokables' => [
            WidgetManager::class        => WidgetManager::class,
            WidgetGroupManager::class   => WidgetGroupManager::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            ThemeOptions::class => ThemeOptionsFactory::class
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'bootstrap'                 => BootStrapTheme::class,
            'socialLinks'               => SocialLinks::class,
            'themeOptions'              => ThemeOptionsHelper::class,
            'themePath'                 => ThemePath::class,
            'widget'                    => WidgetHelper::class,
        ],
        'invokables' => [
            BootStrapTheme::class       => BootStrapTheme::class,
            SocialLinks::class          => SocialLinks::class,
            ThemeOptionsHelper::class   => ThemeOptionsHelper::class,
            ThemePath::class            => ThemePath::class,
            WidgetHelper::class         => WidgetHelper::class,

            Html::class                 => Html::class,
            Content::class              => Content::class,
            LayoutRow::class            => LayoutRow::class,
            Partial::class              => Partial::class,
        ],
    ],
    'view_manager'  => [
        'template_map' => include __DIR__ . '/../template_map.php'
    ],
];
