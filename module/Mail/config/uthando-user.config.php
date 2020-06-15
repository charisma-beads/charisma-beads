<?php

use Mail\Controller\MailQueueController;

return [
    'user' => [
        'acl' => [
            'roles' => [
                'admin'        => [
                    'privileges'    => [
                        'disallow' => [
                            MailQueueController::class => ['action' => ['add', 'edit']],
                        ],
                        'allow' => [
                            'controllers' => [
                                MailQueueController::class => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                MailQueueController::class,
            ],
        ],
    ],
];
