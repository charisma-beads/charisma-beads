<?php

use SessionManager\Controller\SessionManagerConsole;
use SessionManager\Controller\SessionManagerController;
use SessionManager\Controller\SettingsController;

return [
    'router' => [
        'routes' => [
            'admin' => [
                'child_routes' => [
                    'session' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '/session',
                            'defaults' => [
                                '__NAMESPACE__' => 'SessionManager\Controller',
                                'controller'    => SessionManagerController::class,
                                'action'        => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'delete' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/delete',
                                    'defaults' => [
                                        'action'     => 'delete',
                                    ],
                                ],
                            ],
                            'view' => [
                                'type'    => 'Segment',
                                'options' => [
                                    'route'         => '/id/[:id]',
                                    'constraints'   => [
                                        //'id'		=> '\d+'
                                    ],
                                    'defaults'      => [
                                        'action'     => 'view',
                                    ],
                                ],
                            ],
                            'list' => [
                                'type'    => 'Segment',
                                'options' => [
                                    'route'         => '/list',
                                    'defaults'      => [
                                        'action'     => 'list',
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
                                        'action'     => 'list',
                                        'page'       => 1,
                                    ],
                                ],
                            ],
                            'settings' => [
                                'type'    => 'Literal',
                                'options' => [
                                    'route'    => '/settings',
                                    'defaults' => [
                                        '__NAMESPACE__' => 'SessionManager\Controller',
                                        'controller'    => SettingsController::class,
                                        'action'        => 'index',
                                    ],
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
                'session/gc' => [
                    'options' => [
                        'route' => 'session gc',
                        'defaults' => [
                            '__NAMESPACE__' => 'SessionManager\Controller',
                            'controller' => SessionManagerConsole::class,
                            'action' => 'gc'
                        ],
                    ],
                ],
            ],
        ],
    ],
];
