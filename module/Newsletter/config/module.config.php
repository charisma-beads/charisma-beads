<?php

use Newsletter\Controller\MessageController;
use Newsletter\Controller\NewsletterController;
use Newsletter\Controller\PreferencesController;
use Newsletter\Controller\SubscriberAdminController;
use Newsletter\Controller\SubscriberController;
use Newsletter\Controller\TemplateController;
use Newsletter\Service\MessageService;
use Newsletter\Service\NewsletterService;
use Newsletter\Service\SubscriberService;
use Newsletter\Service\SubscriptionService;
use Newsletter\Service\TemplateService;
use Newsletter\View\Renderer\NewsletterRenderer;
use Newsletter\View\Service\NewsletterRendererFactory;
use Newsletter\View\Service\NewsletterStrategyFactory;
use Newsletter\View\Strategy\NewsletterStrategy;

return [
    'asset_manager' => [
        'resolver_configs' => [
            'collections' => [
                'css/uthando-admin.css' => [
                    'css/newsletter-admin.css'
                ],
            ],
            'paths' => [
                'Newsletter' => __DIR__ . '/../public',
            ],
        ],
    ],
    'controllers' => [
        'invokables' => [
            MessageController::class            => MessageController::class,
            NewsletterController::class         => NewsletterController::class,
            PreferencesController::class        => PreferencesController::class,
            SubscriberAdminController::class    => SubscriberAdminController::class,
            SubscriberController::class         => SubscriberController::class,
            TemplateController::class           => TemplateController::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            NewsletterRenderer::class => NewsletterRendererFactory::class,
            NewsletterStrategy::class => NewsletterStrategyFactory::class,
        ]
    ],
    'uthando_services' => [
        'invokables' => [
            MessageService::class       => MessageService::class,
            NewsletterService::class    => NewsletterService::class,
            SubscriberService::class    => SubscriberService::class,
            SubscriptionService::class  => SubscriptionService::class,
            TemplateService::class      => TemplateService::class,
        ],
    ],
    'view_manager' => [
        'strategies' => [
            NewsletterStrategy::class,
        ],
        'template_map' => include __DIR__ . '/../template_map.php'
    ],
    'router' => [
        'routes' => [
            'newsletter' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/newsletter',
                    'defaults' => [
                        '__NAMESPACE__' => 'Newsletter\Controller',
                        'controller' => PreferencesController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'subscribe' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/subscribe',
                            'defaults' => [
                                'controller' => 'Subscriber',
                                'action' => 'add-subscriber',
                            ],
                        ],
                    ],
                    'update' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/update',
                            'defaults' => [
                                'controller' => SubscriberController::class,
                                'action' => 'update-subscription',
                            ],
                            'constraints'   => [
                                'email'    => '[a-zA-Z][a-zA-Z0-9]*',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];