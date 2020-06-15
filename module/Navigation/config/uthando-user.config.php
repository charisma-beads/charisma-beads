<?php

use Navigation\Controller\MenuController;
use Navigation\Controller\MenuItemController;
use Navigation\Controller\SiteMapController;

return [
    'user' => [
        'acl' => [
            'roles' => [
                'guest' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                SiteMapController::class => ['action' => 'all'],
                            ],
                            'resources' => ['menu:guest'],
                        ],
                    ],
                ],
                'registered' => [
                    'privileges' => [
                        'deny' => [
                            'resources' => ['menu:guest'],
                        ],
                        'allow' => [
                            'resources' => ['menu:user'],
                        ],
                    ],
                ],
                'admin' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                MenuController::class       => ['action' => 'all'],
                                MenuItemController::class   => ['action' => 'all'],
                            ],
                            'resources' => ['menu:admin'],
                        ],
                    ],
                ],
            ],
            'resources' => [
                MenuController::class,
                MenuItemController::class,
                SiteMapController::class,
                'menu:admin',
                'menu:guest',
                'menu:user',
            ],
        ],
    ],
];
