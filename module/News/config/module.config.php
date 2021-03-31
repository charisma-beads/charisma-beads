<?php

use News\Controller\FeedController;
use News\Controller\NewsAdminController;
use News\Controller\NewsController;
use News\Controller\SettingsController;
use News\Options\FeedOptions;
use News\Options\NewsOptions;
use News\Service\NewsService;
use News\Service\NewsFeedOptionsFactory;
use News\Service\NewsOptionsFactory;
use News\View\NewsHelper;

return [
    'controllers' => [
        'invokables' => [
            FeedController::class       => FeedController::class,
            NewsController::class       => NewsController::class,
            NewsAdminController::class  => NewsAdminController::class,
            SettingsController::class   => SettingsController::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            FeedOptions::class    => NewsFeedOptionsFactory::class,
            NewsOptions::class    => NewsOptionsFactory::class,
        ]
    ],
    'uthando_services' => [
        'invokables' => [
            NewsService::class => NewsService::class,
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'NewsHelper' => NewsHelper::class
        ],
        'invokables' => [
            NewsHelper::class => NewsHelper::class
        ],
    ],
    'view_manager' => [
        'strategies' => [
            'ViewFeedStrategy',
        ],
        'template_map' => include __DIR__ . '/../template_map.php'
    ],
    'router' => [
        'routes' => [
            'news-list' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/news',
                    'defaults' => [
                        '__NAMESPACE__' => 'News\Controller',
                        'controller'    => NewsController::class,
                        'action'        => 'view',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'search' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'         => '/search/[:search][/[:page]]',
                            'constraints'   => [
                                'search'   => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+',
                            ],
                            'defaults'      => [
                                'action'        => 'view',
                                'search'        => '',
                                'page'          => 1,
                            ],
                        ],
                    ],
                    'tag' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'         => '/tag/[:tag][/[:page]]',
                            'constraints'   => [
                                'tag'   => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+',
                            ],
                            'defaults'      => [
                                'action'        => 'view',
                                'tag'           => '',
                                'page'          => 1,
                            ],
                        ],
                    ],
                    'archives' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'         => '/[:year]/[:month][/[:page]]',
                            'constraints'   => [
                                'year' => '\d+',
                                'month' => '\d+',
                                'page' => '\d+',
                            ],
                            'defaults'      => [
                                'action'     => 'view',
                                'page'       => 1,
                            ],
                        ],
                    ],
                    'page' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'         => '/[:page]',
                            'constraints'   => [
                                'page' => '\d+',
                            ],
                            'defaults'      => [
                                'action'        => 'view',
                                'page'          => 1,
                            ],
                        ],
                    ],
                ],
            ],
            'news' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/news/[:news-item]',
                    'constraints' => [
                        'news-item'  => '[a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        '__NAMESPACE__' => 'News\Controller',
                        'controller'    => NewsController::class,
                        'action'        => 'news-item',
                    ],
                ],
            ],
            'news-feed' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/news/feed',
                    'defaults' => [
                        '__NAMESPACE__' => 'News\Controller',
                        'controller'    => FeedController::class,
                        'action'        => 'feed',
                    ],
                ],
            ],
        ],
    ],
];