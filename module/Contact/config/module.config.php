<?php

use Contact\Controller\ContactController;
use Contact\Controller\SettingsController;
use Contact\Form\AbstractLineFieldSet;
use Contact\Form\CompanyFieldSet;
use Contact\Form\ContactForm;
use Contact\Form\ContactSettings;
use Contact\Form\DetailsFieldSet;
use Contact\Form\FormFieldSet;
use Contact\Form\GoogleMapFieldSet;
use Contact\Form\View\Helper\AbstractLineFormCollection;
use Contact\InputFilter\ContactInputFilter;
use Contact\InputFilter\ContactInputFilterFactory;
use Contact\Options\CompanyOptions;
use Contact\Options\DetailsOptions;
use Contact\Options\FormOptions;
use Contact\Options\GoogleMapOptions;
use Contact\Options\Service\CompanyOptionsFactory;
use Contact\Options\Service\DetailsOptionsFactory;
use Contact\Options\Service\FormOptionsFactory;
use Contact\Options\Service\GoogleMapOptionsFactory;
use Contact\ServiceManager\ContactService;
use Contact\View\Helper\Contact;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'invokables' => [
            ContactController::class    => ContactController::class,
            SettingsController::class   => SettingsController::class,
        ],
    ],
    'form_elements' => [
        'factories' => [
            AbstractLineFieldSet::class => InvokableFactory::class,
            CompanyFieldSet::class      => InvokableFactory::class,
            ContactForm::class          => InvokableFactory::class,
            ContactSettings::class      => InvokableFactory::class,
            DetailsFieldSet::class      => InvokableFactory::class,
            FormFieldSet::class         => InvokableFactory::class,
            GoogleMapFieldSet::class    => InvokableFactory::class
        ],
    ],
    'input_filters' => [
        'factories' => [
           ContactInputFilter::class => ContactInputFilterFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            CompanyOptions::class   => CompanyOptionsFactory::class,
            DetailsOptions::class   => DetailsOptionsFactory::class,
            FormOptions::class      => FormOptionsFactory::class,
            GoogleMapOptions::class => GoogleMapOptionsFactory::class,
        ],
        'invokables' => [
            ContactService::class => ContactService::class,
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'contact'                       => Contact::class,
            'abstractLineFormCollection'    => AbstractLineFormCollection::class,
        ],
        'invokables' => [
            Contact::class                      => Contact::class,
            AbstractLineFormCollection::class   => AbstractLineFormCollection::class,
        ],
    ],
    'view_manager'  => [
        'template_map' => include __DIR__ . '/../template_map.php'
    ],
    'router' => [
        'routes' => [
            'contact' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/contact',
                    'defaults' => [
                        '__NAMESPACE__' => 'Contact\Controller',
                        'controller'    => ContactController::class,
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'process' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/process',
                            'defaults' => [
                                'action' => 'process'
                            ],
                        ],
                    ],
                    'thank-you' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/thank-you',
                            'defaults' => [
                                'action' => 'thank-you'
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'navigation' => [
        'default' => [
            'contact' => [
                'label' => 'ContactService',
                'route' => 'contact',
            ],
        ],
    ],
];
