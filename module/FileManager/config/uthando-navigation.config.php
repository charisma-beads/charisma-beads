<?php

return [
    'navigation' => [
        'admin' => [
            'admin' => [
                'pages' => [
                    'settings' => [
                        'pages' => [
                            'file-manager-settings' => [
                                'label' => 'File Manager',
                                'action' => 'index',
                                'route' => 'admin/file-manager/settings',
                                'resource' => 'menu:admin',
                            ],
                        ],
                    ],

                ],
            ],
            'file-manager' => [
                'label' => 'File manager',
                'params' => [
                    'icon' => 'fa-folder',
                ],
                'pages' => [
                    'file-manager-settings' => [
                        'label' => 'Settings',
                        'action' => 'index',
                        'route' => 'admin/file-manager/settings',
                        'resource' => 'menu:admin',
                        'visible' => false,
                    ],
                ],
                'route'     => 'admin/file-manager',
                'resource'  => 'menu:admin'
            ],
        ],
    ],
];
