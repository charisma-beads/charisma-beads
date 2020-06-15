<?php

use ThemeManager\Controller\SettingsController;
use ThemeManager\Controller\WidgetController;
use ThemeManager\Controller\WidgetGroupController;

return [
    'user' => [
        'acl' => [
            'roles' => [
                'admin' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                SettingsController::class       => ['action' => 'all'],
                                WidgetController::class         => ['action' => 'all'],
                                WidgetGroupController::class    => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                SettingsController::class,
                WidgetController::class,
                WidgetGroupController::class,
            ],
        ],
    ],
];
