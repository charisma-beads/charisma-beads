<?php

use Contact\Controller\ContactController;
use Contact\Controller\SettingsController;

return [
    'user' => [
        'acl' => [
            'roles' => [
                'guest' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                ContactController::class => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
                'admin' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                SettingsController::class => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                ContactController::class,
                SettingsController::class,
            ],
        ],
    ],
];
