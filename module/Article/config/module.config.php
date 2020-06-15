<?php

use Article\Controller\ArticleController;
use Article\Service\ArticleService;
use Article\View\GetPost;
use Article\View\RecentPosts;

return [
    'controllers' => [
        'invokables' => [
            ArticleController::class => ArticleController::class,
        ],
    ],
    'uthando_services' => [
        'invokables' => [
            ArticleService::class => ArticleService::class,
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'UthandoArticleGetPost'     => GetPost::class,
            'UthandoArticleRecentPosts' => RecentPosts::class,
        ],
        'invokables' => [
            GetPost::class     => GetPost::class,
            RecentPosts::class => RecentPosts::class,
        ],
    ],
    'view_manager' => [
        'template_map' => include __DIR__ . '/../template_map.php'
    ],
    'router' => [
        'routes' => [
            'article' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/page/[:slug][/:model]',
                    'constraints' => [
                        'slug'  => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        '__NAMESPACE__' => 'Article\Controller',
                        'controller'    => ArticleController::class,
                        'action'        => 'view',
                        'model'         => false,
                    ],
                ],
            ],
        ],
    ],
];
