<?php

use ShopDomPdf\Controller\SettingsController;

return [
    'user' => [
        'acl' => [
            'roles' => [
                'admin' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                SettingsController::class => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                SettingsController::class
            ],
        ],
    ],
];
