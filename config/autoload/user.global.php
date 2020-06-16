<?php

declare(strict_types=1);

return [
    'user' => [
        'acl' => [
            'roles' => [
                'guest' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                Admin\Controller\IndexController::class => ['action' => [
                                    'login',  'forgot-password',
                                ]],
                            ],
                        ],
                    ],
                ],
                'admin' => [
                    'privileges' => [
                        'deny' => [
                            'controllers' => [
                                Admin\Controller\IndexController::class => ['action' => [
                                    'login', 'forgot-password'
                                ]],
                            ],
                        ],
                        'allow' => [
                            'controllers' => [
                                Admin\Controller\IndexController::class => ['action' => [
                                    'index', 'logout', 'password', 'profile',
                                ]],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                Admin\Controller\IndexController::class,
            ],
        ],
    ],
];