<?php

namespace User;

use User\Authentication\Storage;
use User\Options\LoginOptions;
use User\Options\AuthOptions;
use User\Options\UserOptions;
use User\Service\Acl;
use User\Service\Factory\AclFactory;
use User\Service\Factory\AuthenticationFactory;
use User\Service\Factory\AuthOptionsFactory;
use User\Service\Factory\LoginOptionsFactory;
use User\Service\Factory\UserNavigationFactory;
use User\Service\Factory\UserOptionsFactory;
use User\Service\LimitLoginService;
use User\Service\UserService as UserService;
use User\Service\UserRegistrationService as UserRegistrationService;
use User\View\IsAllowed;
use Zend\Authentication\AuthenticationService;

return [
    'controllers' => [
        'invokables' => [
            Controller\AdminController::class              => Controller\AdminController::class,
            Controller\AdminRegistrationController::class  => Controller\AdminRegistrationController::class,
            Controller\LimitLoginController::class         => Controller\LimitLoginController::class,
            Controller\RegistrationController::class       => Controller\RegistrationController::class,
            Controller\SettingsController::class           => Controller\SettingsController::class,
            Controller\UserConsoleController::class        => Controller\UserConsoleController::class,
            Controller\UserController::class               => Controller\UserController::class,
        ],
    ],
    'controller_plugins' => [
        'aliases' => [
            'isAllowed' => Controller\Plugin\IsAllowed::class,
        ],
        'invokables' => [
            Controller\Plugin\IsAllowed::class => Controller\Plugin\IsAllowed::class,
        ],
    ],
    'service_manager' => [
        'aliases' => [
            'User\Navigation'        => UserNavigationFactory::class,
            'User\Options\User'      => UserOptions::class,
        ],
        'invokables' => [
            Storage::class => Storage::class,
        ],
        'factories' => [
            AuthenticationService::class    => AuthenticationFactory::class,
            Acl::class                      => AclFactory::class,
            UserNavigationFactory::class    => UserNavigationFactory::class,
            AuthOptions::class              => AuthOptionsFactory::class,
            LoginOptions::class             => LoginOptionsFactory::class,
            UserOptions::class              => UserOptionsFactory::class
        ],
    ],
    'uthando_services' => [
        'invokables' => [
            LimitLoginService::class        => LimitLoginService::class,
            UserService::class              => UserService::class,
            UserRegistrationService::class  => UserRegistrationService::class,
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'isAllowed' => IsAllowed::class,
        ],
        'invokables' => [
            IsAllowed::class => IsAllowed::class,
        ],
    ],
    'view_manager' => [
        'template_map' => include __DIR__ . '/../template_map.php',
    ],
    'router' => [
        'routes' => [
            'login' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/login',
                    'defaults' => [
                        '__NAMESPACE__' => 'User\Controller',
                        'controller'    => Controller\UserController::class,
                        'action'        => 'login',
                    ],
                ],
                'may_terminate' => true,
            ],
            'user' => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '/user[/[:action]]',
                    'constraints' => [
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*'
            		],
                    'defaults' => [
                        '__NAMESPACE__' => 'User\Controller',
                        'controller'    => Controller\UserController::class,
                        'action'        => 'login',
                    ],
                ],
                'may_terminate' => true,
            ],
            'registration' => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '/registration[/[:action]/[:token]/[:email]]',
                    'constraints' => [
                        'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'token'     => '[a-zA-Z0-9]*',
                        //'email'     => '[a-zA-Z0-9@-_.]*',
                    ],
                    'defaults' => [
                        '__NAMESPACE__' => 'User\Controller',
                        'controller'    => Controller\RegistrationController::class,
                        'token'         => '',
                        'email'         => '',
                    ],
                ],
                'may_terminate' => true,
            ],
        ],
    ],
];
