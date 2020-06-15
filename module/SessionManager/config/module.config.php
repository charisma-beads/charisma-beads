<?php

use SessionManager\Controller\Plugin\SessionContainer;
use SessionManager\Controller\SessionManagerConsole;
use SessionManager\Controller\SessionManagerController;
use SessionManager\Controller\SettingsController;
use SessionManager\Options\SessionOptions;
use SessionManager\Service\Factory\SessionConfigOptionsFactory;
use SessionManager\Service\Factory\SessionManagerFactory;
use SessionManager\Service\Factory\SessionOptionsFactory;
use SessionManager\Service\Factory\SessionSaveHandlerFactory;
use SessionManager\Service\SessionManagerService;
use SessionManager\View\DecodeSession;

return [
    'controllers' => [
        'invokables' => [
            SessionManagerConsole::class    => SessionManagerConsole::class,
            SessionManagerController::class => SessionManagerController::class,
            SettingsController::class       => SettingsController::class
        ],
    ],
    'controller_plugins' => [
        'aliases' => [
            'sessionContainer' => SessionContainer::class
        ],
        'invokables' => [
            SessionContainer::class => SessionContainer::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            SessionConfigOptionsFactory::class  => SessionConfigOptionsFactory::class,
            SessionManagerFactory::class        => SessionManagerFactory::class,
            SessionOptions::class               => SessionOptionsFactory::class,
            SessionSaveHandlerFactory::class    => SessionSaveHandlerFactory::class,
        ],
    ],
    'uthando_services' => [
        'invokables' => [
            SessionManagerService::class => SessionManagerService::class
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'DecodeSession' => DecodeSession::class,
        ],
        'invokables' => [
            DecodeSession::class => DecodeSession::class
        ],
    ],
    'view_manager' => [
        'template_map' => include __DIR__ . '/../template_map.php'
    ],
];
