<?php

use Mail\Controller\MailQueueConsoleController;
use Mail\Controller\MailQueueController;
use Mail\Options\MailOptions;
use Mail\Service\Factory\MailFactory;
use Mail\Service\Factory\MailOptionsFactory;
use Mail\Service\Mail;
use Mail\Service\MailQueueService;
use Mail\View\Helper\MailAddress;

return [
    'controllers' => [
        'invokables' => [
            MailQueueController::class          => MailQueueController::class,
            MailQueueConsoleController::class   => MailQueueConsoleController::class
        ],
    ],
    'service_manager' => [
        'factories' => [
            Mail::class         => MailFactory::class,
            MailOptions::class  => MailOptionsFactory::class,
        ],
    ],
    'uthando_services' => [
        'invokables' => [
            MailQueueService::class => MailQueueService::class
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'UthandoMailAddress' => MailAddress::class,
        ],
        'invokables' => [
            MailAddress::class => MailAddress::class
        ],
    ],
    'view_manager' => [
         'template_map' => include __DIR__ . '/../template_map.php',
    ],
];
