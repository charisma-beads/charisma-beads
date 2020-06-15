<?php

use Navigation\Controller\MenuController;
use Navigation\Controller\MenuItemController;
use Navigation\Controller\SiteMapController;
use Navigation\Service\DbNavigationAbstractFactory;
use Navigation\Service\DbNavigationFactory;
use Navigation\Service\MenuService;
use Navigation\Service\MenuItemService;
use Navigation\Service\SiteMapService;
use Navigation\View;
use Navigation\View\Service\NavigationFactory;

return [
    'controllers' => [
        'invokables' => [
            MenuController::class       => MenuController::class,
            MenuItemController::class   => MenuItemController::class,
            SiteMapController::class    => SiteMapController::class,
        ],
    ],
    'service_manager' => [
        'aliases' => [
            'Navigation\DbNavigation' => View\Navigation::class,
        ],
        'factories' => [
            View\Navigation::class => DbNavigationFactory::class,
        ],
        'abstract_factories' => [
            DbNavigationAbstractFactory::class,
        ],
    ],
    'uthando_services' => [
        'invokables' => [
            MenuService::class     => MenuService::class,
            MenuItemService::class => MenuItemService::class,
            SiteMapService::class  => SiteMapService::class,
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'navigationForm'    => View\NavigationForm::class,
            'uthandoNavigation' => View\Navigation::class,
        ],
        'factories' => [
            View\Navigation::class => NavigationFactory::class,
        ],
        'invokables' => [
            View\NavigationForm::class    => View\NavigationForm::class,
        ],
    ],
    'view_manager' => [
        'template_map' => include __DIR__ . '/../template_map.php',
    ],
    'router' => [
        'routes' => [
            'site-map' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/sitemap.xml',
                    'defaults' => [
                        '__NAMESPACE__' => 'Navigation\Controller',
                        'controller' => SiteMapController::class,
                        'action' => 'index',
                    ]
                ],
            ],
        ],
    ],
];
