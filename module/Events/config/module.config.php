<?php

use Events\Controller\EventsController;
use Events\Controller\SettingsController;
use Events\Controller\TimeLineController;
use Events\Options\EventsOptions;
use Events\ServiceManager\EventsOptionsFactory;
use Events\ServiceManager\EventsService;
use Events\View\Helper;

return [
    'asset_manager' => [
        'resolver_configs' => [
            'collections' => [
                'css/uthando-admin.css' => [
                    'css/event-styles.css',
                ],
            ],
            'paths' => [
                'Events' => __DIR__ . '/../public',
            ],
        ],
    ],
    'controllers' => [
        'invokables' => [
            EventsController::class => EventsController::class,
            SettingsController::class => SettingsController::class,
            TimeLineController::class => TimeLineController::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            EventsOptions::class => EventsOptionsFactory::class,
        ]
    ],
    'uthando_services' => [
        'invokables' => [
            EventsService::class => EventsService::class
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'ConvertDateFormat' => Helper\ConvertDateFormat::class,
            'EventsOptions'     => \Events\View\Helper\EventsOptions::class,
        ],
        'invokables' => [
            Helper\ConvertDateFormat::class => Helper\ConvertDateFormat::class,
            Helper\EventsOptions::class => Helper\EventsOptions::class,
        ],
    ],
    'view_manager' => [
        'template_map' => include __DIR__ . '/../template_map.php',
        'template_path_stack' => [
            'events' => __DIR__ . '/../view'
        ],
    ],
    'router' => [
        'routes' => [
            'events' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/events',
                    'defaults' => [
                        '__NAMESPACE__' => 'Events\Controller',
                        'controller'    => TimeLineController::class,
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
            ],
        ],
    ],

];
