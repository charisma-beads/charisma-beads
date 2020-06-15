<?php

return [
    'asset_manager' => [
        'resolver_configs' => [
            'collections' => [
                'js/uthando.js' => [
                ],
                'css/uthando.css' => [
                ],
            ],
            'paths' => [
                'Twitter' => __DIR__ . '/../public',
            ],
        ],
    ],
    'controllers' => [
        'invokables' => [
            \Twitter\Controller\TwitterController::class => \Twitter\Controller\TwitterController::class,
            \Twitter\Controller\SettingsController::class => \Twitter\Controller\SettingsController::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            \Facebook\Facebook::class => \Twitter\Service\FacebookFactory::class,
            \Twitter\Service\Twitter::class => \Twitter\Service\TwitterFactory::class,

            \Twitter\Option\FacebookOptions::class => \Twitter\Option\FacebookOptionsFactory::class,
            \Twitter\Option\TwitterOptions::class => \Twitter\Option\TwitterOptionsFactory::class,
        ],
    ],
    'view_helpers' => [
        'invokables' => [
            'TweetFeed' => \Twitter\View\TweetFeed::class,
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'twitter/settings/index' => __DIR__ . '/../view/twitter/settings/index.phtml',
            'twitter/twitter/twitter-feed' => __DIR__ . '/../view/twitter/twitter/twitter-feed.phtml',
        ],
    ],
    'router' => [
        'routes' => [
            'twitter' => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '/twitter[/][:action]',
                    'constraints' => [
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        '__NAMESPACE__' => 'Twitter\Controller',
                        'controller'    => \Twitter\Controller\TwitterController::class,
                        'action'        => 'twitter-feed',
                    ],
                ],
                'may_terminate' => true,
            ],
        ],
    ],
];
