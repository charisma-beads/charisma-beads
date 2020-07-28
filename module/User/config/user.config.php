<?php

namespace User;

return [
    'user' => [
        'acl' => [
            'roles' => [
                'guest' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                Controller\UserController::class => ['action' => [
                                    'register', 'thank-you', 'login', 'authenticate', 'forgot-password'
                                ]],
                                Controller\RegistrationController::class => ['action' => [
                                    'verify-email',
                                ]],
                            ],
                        ],
                    ],
                ],
                'registered' => [
                    'privileges' => [
                        'deny' => [
                            'controllers' => [
                                Controller\UserController::class => ['action' => [
                                    'register', 'thank-you', 'login', 'authenticate', 'forgot-password'
                                ]],
                                Controller\RegistrationController::class => ['action' => [
                                    'verify-email',
                                ]],
                            ],
                        ],
                        'allow' => [
                            'controllers' => [
                                Controller\UserController::class => [
                                    'action' => ['edit', 'password', 'logout']
                                ]
                            ],
                        ],
                    ],
                ],
                'admin' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                Controller\AdminController::class => ['action' => 'all'],
                                Controller\AdminRegistrationController::class => [
                                    'action' => ['index', 'list', 'delete']
                                ],
                                Controller\LimitLoginController::class => [
                                    'action' => ['index', 'list', 'delete']
                                ],
                                Controller\SettingsController::class => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                Controller\AdminController::class,
                Controller\AdminRegistrationController::class,
                Controller\LimitLoginController::class,
                Controller\RegistrationController::class,
                Controller\SettingsController::class,
                Controller\UserController::class,
            ],
        ],
    ],
];
