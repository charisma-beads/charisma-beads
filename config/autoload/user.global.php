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
                                User\Controller\UserController::class => ['action' => [
                                    'register', 'thank-you', 'login', 'authenticate', 'forgot-password'
                                ]],
                                User\Controller\RegistrationController::class => ['action' => [
                                    'verify-email',
                                ]],
                            ],
                        ],
                    ],
                ],
                'registered' => [
                    'label' => 'User',
                    'parent' => 'guest',
                    'privileges' => [
                        'deny' => [
                            'controllers' => [
                                User\Controller\UserController::class => ['action' => [
                                    'register', 'thank-you', 'login', 'authenticate', 'forgot-password'
                                ]],
                                User\Controller\RegistrationController::class => ['action' => [
                                    'verify-email',
                                ]],
                            ],
                        ],
                        'allow' => [
                            'controllers' => [
                                Application\Controller\IndexController::class => ['action' => ['index']],
                                User\Controller\UserController::class => [
                                    'action' => ['edit', 'password', 'logout']
                                ]
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
                                User\Controller\AdminController::class => ['action' => 'all'],
                                User\Controller\AdminRegistrationController::class => [
                                    'action' => ['index', 'list', 'delete']
                                ],
                                User\Controller\LimitLoginController::class => [
                                    'action' => ['index', 'list', 'delete']
                                ],
                                User\Controller\SettingsController::class => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                Admin\Controller\IndexController::class,
                Application\Controller\IndexController::class,
                User\Controller\AdminController::class,
                User\Controller\AdminRegistrationController::class,
                User\Controller\LimitLoginController::class,
                User\Controller\RegistrationController::class,
                User\Controller\SettingsController::class,
                User\Controller\UserController::class,
            ],
        ],
    ],
];