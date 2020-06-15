<?php

return [
    'navigation' => [
        'admin' => [
            'admin' => [
                'pages' => [
                    'settings' => [
                        'pages' => [
                            'events-settings' => [
                                'label' => 'Events',
                                'action' => 'index',
                                'route' => 'admin/events/settings',
                                'resource' => 'menu:admin',
                            ],
                        ],
                    ],
                ],
            ],
            'events' => [
                'label' => 'Events',
                'params' => [
                    'icon' => 'fa-calendar-o',
                ],
                'pages' => [
                    'list' => [
                        'label'     => 'List Events',
                        'action'    => 'index',
                        'route'     => 'admin/events',
                        'resource'  => 'menu:admin',
                        'visible'   => false,
                    ],
                    'add' => [
                        'label'     => 'Add Event',
                        'action'    => 'add',
                        'route'     => 'admin/events/edit',
                        'resource'  => 'menu:admin',
                        'visible'   => false,
                    ],
                    'edit' => [
                        'label'     => 'Edit Event',
                        'action'    => 'edit',
                        'route'     => 'admin/events/edit',
                        'resource'  => 'menu:admin',
                        'visible'   => false,
                    ],
                    'settings' => [
                        'label' => 'Settings',
                        'action' => 'index',
                        'route' => 'admin/events/settings',
                        'resource' => 'menu:admin',
                        'visible'   => false,
                    ],
                ],
                'route' => 'admin/events',
                'resource' => 'menu:admin'
            ],
        ],
    ],
];
