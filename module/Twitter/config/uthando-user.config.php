<?php

return [
    'user' => [
        'acl' => [
            'roles' => [
                'guest' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                \Twitter\Controller\TwitterController::class => ['action' => ['twitter-feed']],
                            ],
                        ],
                    ],
                ],
                'admin' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                \Twitter\Controller\SettingsController::class => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                \Twitter\Controller\TwitterController::class,
                \Twitter\Controller\SettingsController::class,
            ],
        ],
    ],
];
