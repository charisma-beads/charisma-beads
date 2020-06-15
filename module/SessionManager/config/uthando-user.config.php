<?php

use SessionManager\Controller\SessionManagerController;
use SessionManager\Controller\SettingsController;

return [
    'user' => [
        'acl' => [
            'roles' => [
                'admin' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                SessionManagerController::class => ['action' => 'all'],
                                SettingsController::class       => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                SessionManagerController::class,
                SettingsController::class,
            ],
        ],
    ],
];
