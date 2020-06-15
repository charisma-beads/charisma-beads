<?php

use News\Controller\FeedController;
use News\Controller\NewsAdminController;
use News\Controller\NewsController;
use News\Controller\SettingsController;

return [
    'user' => [
        'acl' => [
            'roles' => [
                'guest' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                FeedController::class => ['action' => ['feed']],
                                NewsController::class => ['action' => ['view', 'news-item']],
                            ],
                        ],
                    ],
                ],
                'admin' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                NewsAdminController::class => ['action' => 'all'],
                                SettingsController::class => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                FeedController::class,
                NewsController::class,
                NewsAdminController::class,
                SettingsController::class,
            ],
        ],
    ],
];
