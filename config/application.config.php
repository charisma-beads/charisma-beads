<?php

return [
    'modules' => [
        'AssetManager',
        'Application',
        'Common',
        'Admin',
        'SessionManager',
        'User',
        'ThemeManager',
        'Article',
        'Navigation',
        'Mail',
        'Contact',
        'FileManager',
        'Testimonial',
        'News',
        'Twitter',
        'Newsletter',
        'Events',
        'ShopDomPdf',
        'TwbBundle',
        'Shop',
    ],
    'module_listener_options' => [
        'module_paths' => [
            './vendor',
            './module'
        ],
        'config_glob_paths' => [
            'config/autoload/{,*.}{global,local}.php'
        ],
        'config_cache_enabled' => false,
        'config_cache_key' => 'config-cache',
        'module_map_cache_enabled' => false,
        'module_map_cache_key' => 'module-map-cache',
        'cache_dir' => './data/cache',
        'check_dependencies' => true,
    ],
    'service_manager' => [
        'invokables' => [
            'ModuleRouteListener' => 'Zend\Mvc\ModuleRouteListener'
        ],
        'factories' => [
            'Navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory'
        ]
    ]
];
