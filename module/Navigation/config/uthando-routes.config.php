<?php

use Navigation\Controller\MenuController;
use Navigation\Controller\MenuItemController;

return [
    'router' => [
        'routes' => [
            'admin' => [
                'child_routes' => [
                    'menu' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/menu',
                            'defaults' => [
                                '__NAMESPACE__' => 'Navigation\Controller',
                                'controller' => MenuController::class,
                                'action' => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'edit' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/[:action[/id/[:id]]]',
                                    'constraints' => [
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id' => '\d+'
                                    ],
                                    'defaults' => [
                                        'action' => 'edit',
                                    ],
                                ],
                            ],
                            'page' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/page/[:page]',
                                    'constraints' => [
                                        'page' => '\d+'
                                    ],
                                    'defaults' => [
                                        'action' => 'list',
                                        'page' => 1,
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'menu-item' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/menu-item[/menuId/[:menuId]]',
                            'constraints' => [
                                //'id' 		 => '\d+',
                                'menuId' => '\d+',
                            ],
                            'defaults' => [
                                '__NAMESPACE__' => 'Navigation\Controller',
                                'controller' => MenuItemController::class,
                                'action' => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'edit' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/[:action[/id/[:id]]]',
                                    'constraints' => [
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        //'menuId' 	=> '\d+',
                                        'id' => '\d+'
                                    ],
                                    'defaults' => [
                                        'action' => 'edit',
                                    ],
                                ],
                            ],
                            'page' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/page/[:page]',
                                    'constraints' => [
                                        'page' => '\d+'
                                    ],
                                    'defaults' => [
                                        'action' => 'list',
                                        'page' => 1,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
