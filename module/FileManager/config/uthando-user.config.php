<?php

use FileManager\Controller\FileManagerController;
use FileManager\Controller\SettingsController;
use FileManager\Controller\UploaderController;

return [
    'user' => [
        'acl' => [
            'roles' => [
                'admin' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                FileManagerController::class => ['action' => 'all'],
                                SettingsController::class => ['action' => 'all'],
                                UploaderController::class => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                FileManagerController::class,
                SettingsController::class,
                UploaderController::class,
            ],
        ],
    ],
];
