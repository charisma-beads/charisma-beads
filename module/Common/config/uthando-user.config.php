<?php

return [
    'user' => [
        'acl' => [
            'roles' => [
                'guest' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                \Common\Controller\CaptchaController::class => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
                'admin' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                \Common\Mvc\Controller\Settings::class => ['action' => 'all'],
                            ]
                        ]
                    ]
                ]
            ],
            'resources' => [
                \Common\Controller\CaptchaController::class,
                \Common\Mvc\Controller\Settings::class
            ],
        ],
    ],
];
