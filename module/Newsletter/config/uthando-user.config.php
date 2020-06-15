<?php

use Newsletter\Controller\MessageController;
use Newsletter\Controller\NewsletterController;
use Newsletter\Controller\PreferencesController;
use Newsletter\Controller\SettingsController;
use Newsletter\Controller\SubscriberAdminController;
use Newsletter\Controller\SubscriberController;
use Newsletter\Controller\TemplateController;

return [
    'user' => [
        'acl' => [
            'roles' => [
                'guest' => [
                    'privileges'    => [
                        'allow' => [
                            'controllers' => [
                                PreferencesController::class => ['action' => ['index',]],
                                SubscriberController::class => ['action' => ['add-subscriber']],
                            ],
                        ],
                    ],
                ],
                'registered' => [
                    'privileges'    => [
                        'allow' => [
                            'controllers' => [
                                SubscriberController::class => ['action' => ['update-subscription']],
                            ],
                        ],
                    ],
                ],
                'admin' => [
                    'privileges'    => [
                        'allow' => [
                            'controllers' => [
                                MessageController::class => ['action' => 'all'],
                                NewsletterController::class => ['action' => 'all'],
                                SettingsController::class => ['action' => 'all'],
                                SubscriberAdminController::class => ['action' => 'all'],
                                TemplateController::class => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                MessageController::class,
                NewsletterController::class,
                PreferencesController::class,
                SettingsController::class,
                SubscriberController::class,
                SubscriberAdminController::class,
                TemplateController::class,
            ],
        ],
    ],
];
