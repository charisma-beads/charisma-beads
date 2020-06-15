<?php

return [
    'navigation' => [
        'admin' => [
            'admin' => [
                'pages' => [
                    'settings' => [
                        'pages' => [
                            'social-media-settings' => [
                                'label' => 'Social Media',
                                'action' => 'index',
                                'route' => 'admin/twitter',
                                'resource' => 'menu:admin',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
