<?php

return [
    'navigation' => [
        'admin' => [
            'admin' => [
                'pages' => [
                    'settings' => [
                        'pages' => [
                            'session-settings' => [
                                'label' => 'Session Manager',
                                'action' => 'index',
                                'route' => 'admin/session/settings',
                                'resource' => 'menu:admin',
                            ],
                        ],
                    ],

                ],
            ],
            'session' => [
                'label' => 'Session Manager',
                'params' => [
                    'icon' => 'fa-cog',
                ],
                'route' => 'admin/session',
                'resource' => 'menu:admin',
            ],
        ],
    ],
];
