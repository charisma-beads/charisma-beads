<?php

declare(strict_types=1);

return [
    'user' => [
        'acl' => [
            'roles' => [
                'guest' => [
                    'label' => 'Guest',
                    'parent' => null,
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                Admin\Controller\IndexController::class => ['action' => [
                                    'login',  'forgot-password',
                                ]],
                                Application\Controller\IndexController::class => ['action' => ['index']],
                            ],
                        ],
                    ],
                ],
                'registered' => [
                    'label' => 'User',
                    'parent' => 'guest',
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                Application\Controller\IndexController::class => ['action' => ['index']],
                            ],
                        ],
                    ]
                ],
                'admin' => [
                    'label' => 'Admin',
                    'parent' => 'registered',
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
                Application\Controller\IndexController::class
            ],
        ],
    ],
];