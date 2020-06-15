<?php

use Admin\Controller\IndexController;

return [
    'user' => [
        'acl' => [
            'roles' => [
                'guest' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                IndexController::class => ['action' => [
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
                                IndexController::class => ['action' => [
                                    'login', 'forgot-password'
                                ]],
                            ],
                        ],
                        'allow' => [
                            'controllers' => [
                                IndexController::class => ['action' => [
                                    'index', 'logout', 'password', 'profile',
                                ]],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                IndexController::class,
            ],
        ],
    ],
];
