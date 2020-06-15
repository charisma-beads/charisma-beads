<?php

return [
    'router' => [
        'routes' => [
            'admin' => [
                'child_routes' => [
                    'twitter' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '/twitter',
                            'defaults' => [
                                '__NAMESPACE__' => 'Twitter\Controller',
                                'controller'    => \Twitter\Controller\SettingsController::class,
                                'action'        => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                ],
            ],
        ],
    ],
];
