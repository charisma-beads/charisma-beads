<?php

return [
    'modules' => [
        'AssetManager',
        'Application',
        'UthandoCommon',
        'UthandoAdmin',
        'UthandoSessionManager',
        'UthandoUser',
        'UthandoThemeManager',
        'UthandoArticle',
        'UthandoNavigation',
        'UthandoMail',
        'UthandoContact',
        'UthandoFileManager',
        'UthandoTestimonial',
        'UthandoNews',
        'UthandoTwitter',
        'UthandoNewsletter',
        'UthandoEvents',
        'UthandoDomPdf',
        'TwbBundle',
        'Shop',
    ],
    'module_listener_options' => [
        'module_paths' => [
            './vendor',
            './devmodules',
            './module'
        ],
        'config_glob_paths' => [
            'config/autoload/{,*.}{global,local}.php'
        ],
        'config_cache_enabled' => true,
        'config_cache_key' => 'config-cache',
        'module_map_cache_enabled' => true,
        'module_map_cache_key' => 'module-map-cache',
        'cache_dir' => './data/cache',
        'check_dependencies' => false
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