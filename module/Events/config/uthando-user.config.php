<?php

use Events\Controller\EventsController;
use Events\Controller\SettingsController;
use Events\Controller\TimeLineController;

return [
    'user' => [
        'acl' => [
            'roles' => [
                'guest' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                TimeLineController::class => ['action' => ['index']],
                            ],
                        ],
                    ],
                ],
                'admin' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                EventsController::class => ['action' => 'all'],
                                SettingsController::class => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                EventsController::class,
                SettingsController::class,
                TimeLineController::class,
            ],
        ],
    ],
];
