<?php

return [
    'navigation' => [
        'admin' => [
            'admin' => [
                'pages' => [
                    'settings' => [
                        'pages' => [
                            'news-settings' => [
                                'label' => 'News',
                                'action' => 'index',
                                'route' => 'admin/news/settings',
                                'resource' => 'menu:admin',
                            ],
                        ],
                    ],
                ],
            ],
            'news' => [
                'label' => 'News',
                'params' => [
                    'icon' => 'fa-newspaper-o',
                ],
                'pages' => [
                    'list' => [
                        'label'     => 'List News',
                        'action'    => 'index',
                        'route'     => 'admin/news',
                        'resource'  => 'menu:admin',
                        'visible' => false,
                    ],
                    'add' => [
                        'label'     => 'Add News',
                        'action'    => 'add',
                        'route'     => 'admin/news/edit',
                        'resource'  => 'menu:admin',
                        'visible' => false,
                    ],
                    'edit' => [
                        'label'     => 'Edit News',
                        'action'    => 'edit',
                        'route'     => 'admin/news/edit',
                        'resource'  => 'menu:admin',
                        'visible' => false,
                    ],
                    'news-settings' => [
                        'label' => 'Settings',
                        'action' => 'index',
                        'route' => 'admin/news/settings',
                        'resource' => 'menu:admin',
                        'visible' => false,
                    ],
                ],
                'route'     => 'admin/news',
                'resource'  => 'menu:admin'
            ],
        ],
    ],
];
