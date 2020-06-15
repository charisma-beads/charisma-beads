<?php

use Newsletter\Controller\MessageController;
use Newsletter\Controller\NewsletterController;
use Newsletter\Controller\SubscriberAdminController;
use Newsletter\Controller\TemplateController;

return [
    'router' => [
        'routes' => [
            'admin' => [
                'child_routes' => [
                    'newsletter' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/newsletter',
                            'defaults' => [
                                '__NAMESPACE__' => 'Newsletter\Controller',
                                'controller' => NewsletterController::class,
                                'action' => 'index',
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
                                        'action'        => 'list',
                                        'page'          => 1,
                                    ],
                                ],
                            ],
                            'message' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/message',
                                    'defaults' => [
                                        'controller' => MessageController::class,
                                        'action' => 'index',
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
                                                'action'        => 'list',
                                                'page'          => 1,
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                            'subscriber' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/subscriber',
                                    'defaults' => [
                                        'controller' => SubscriberAdminController::class,
                                        'action' => 'index',
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
                                                'action'        => 'list',
                                                'page'          => 1,
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                            'template' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/template',
                                    'defaults' => [
                                        'controller' => TemplateController::class,
                                        'action' => 'index',
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
                                                'action'        => 'list',
                                                'page'          => 1,
                                            ],
                                        ],
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
