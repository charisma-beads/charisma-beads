<?php

namespace User;

use User\Controller\UserConsoleController;

return [
    'router' => [
        'routes' => [
            'admin' => [
                'child_routes' => [
                    'user' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '/user',
                            'defaults' => [
                                '__NAMESPACE__' => 'User\Controller',
                                'controller'    => Controller\AdminController::class,
                                'action'        => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'edit' => [
                                'type'    => 'Segment',
                                'options' => [
                                    'route'         => '/[:action[/id/[:id]]]',
                                    'constraints'   => [
                                        'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id'		=> '\d+'
                                    ],
                                    'defaults'      => [
                                        'controller'    => Controller\AdminController::class,
                                        'action'        => 'edit',
                                    ],
                                ],
                            ],
                            'page' => [
                                'type'    => 'Segment',
                                'options' => [
                                    'route'         => '/page/[:page]',
                                    'constraints'   => [
                                        'page'			=> '\d+'
                                    ],
                                    'defaults'      => [
                                        'controller'    => Controller\AdminController::class,
                                        'action'        => 'list',
                                        'page'          => 1,
                                    ],
                                ],
                            ],
                            'registration' => [
                                'type'    => 'Segment',
                                'options' => [
                                    'route'    => '/registration',
                                    'defaults' => [
                                        'controller'    => Controller\AdminRegistrationController::class,
                                        'action'        => 'index',
                                    ],
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'edit' => [
                                        'type'    => 'Segment',
                                        'options' => [
                                            'route'         => '/[:action[/id/[:id]]]',
                                            'constraints'   => [
                                                'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id'		=> '\d+'
                                            ],
                                            'defaults'      => [
                                                'controller'    => Controller\AdminRegistrationController::class,
                                                'action'        => 'edit',
                                            ],
                                        ],
                                    ],
                                    'page' => [
                                        'type'    => 'Segment',
                                        'options' => [
                                            'route'         => '/page/[:page]',
                                            'constraints'   => [
                                                'page'			=> '\d+'
                                            ],
                                            'defaults'      => [
                                                'controller'    => Controller\AdminRegistrationController::class,
                                                'action'        => 'list',
                                                'page'          => 1,
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                            'limit-login' => [
                                'type'    => 'Segment',
                                'options' => [
                                    'route'    => '/limit-login',
                                    'defaults' => [
                                        'controller'    => Controller\LimitLoginController::class,
                                        'action'        => 'index',
                                    ],
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'edit' => [
                                        'type'    => 'Segment',
                                        'options' => [
                                            'route'         => '/[:action[/id/[:id]]]',
                                            'constraints'   => [
                                                'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id'		=> '\d+'
                                            ],
                                            'defaults'      => [
                                                'controller'    => Controller\LimitLoginController::class,
                                                'action'        => 'edit',
                                            ],
                                        ],
                                    ],
                                    'page' => [
                                        'type'    => 'Segment',
                                        'options' => [
                                            'route'         => '/page/[:page]',
                                            'constraints'   => [
                                                'page'			=> '\d+'
                                            ],
                                            'defaults'      => [
                                                'controller'    => Controller\LimitLoginController::class,
                                                'action'        => 'list',
                                                'page'          => 1,
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                            'settings' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/settings[/:action]',
                                    'constraints' => [
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    ],
                                    'defaults' => [
                                        'controller'    => Controller\SettingsController::class,
                                        'action' => 'index',
                                    ]
                                ],
                                'may_terminate' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'console' => [
        'router' => [
            'routes' => [
                'user/cleanup' => [
                    'options' => [
                        'route' => 'user cleanup',
                        'defaults' => [
                            '__NAMESPACE__' => 'User\Controller',
                            'controller' => UserConsoleController::class,
                            'action' => 'cleanup'
                        ],
                    ],
                ],
            ],
        ],
    ],
];
