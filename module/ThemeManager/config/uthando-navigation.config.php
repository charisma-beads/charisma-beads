<?php

return [
    'navigation' => [
        'admin' => [
            'theme-manager' => [
                'label' => 'Theme Manager',
                'params' => [
                    'icon' => 'fa-paint-brush',
                ],
                'pages' => [
                    'widget' => [
                        'label'     => 'Widgets',
                        'action'    => 'index',
                        'route'     => 'admin/theme-manager/widget',
                        'resource'  => 'menu:admin',
                        'pages' => [
                            'add' => [
                                'label'     => 'Add Widget',
                                'action'    => 'add',
                                'route'     => 'admin/theme-manager/widget',
                                'resource'  => 'menu:admin',
                                'visible' => false,
                            ],
                            'edit' => [
                                'label'     => 'Edit Widget',
                                'action'    => 'edit',
                                'route'     => 'admin/theme-manager/widget',
                                'resource'  => 'menu:admin',
                                'visible' => false,
                            ],
                        ],
                    ],
                    'widget-group' => [
                        'label'     => 'Widget Group',
                        'action'    => 'index',
                        'route'     => 'admin/theme-manager/widget-group',
                        'resource'  => 'menu:admin',
                        'pages' => [
                            'add' => [
                                'label'     => 'Add Widget Group',
                                'action'    => 'add',
                                'route'     => 'admin/theme-manager/widget-group',
                                'resource'  => 'menu:admin',
                                'visible' => false,
                            ],
                            'edit' => [
                                'label'     => 'Edit Widget Group',
                                'action'    => 'edit',
                                'route'     => 'admin/theme-manager/widget-group',
                                'resource'  => 'menu:admin',
                                'visible' => false,
                            ],
                        ],
                    ],
                    'theme-manager-settings' => [
                        'label' => 'Settings',
                        'action' => 'index',
                        'route' => 'admin/theme-manager/settings',
                        'resource' => 'menu:admin',
                        'visible' => true,
                    ],
                ],
                'route'     => 'admin/theme-manager',
                'resource'  => 'menu:admin'
            ],
        ],
    ],
];
