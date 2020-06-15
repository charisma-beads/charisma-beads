<?php

use Admin\Controller\IndexController;
use Admin\Service\AdminNavigationFactory;
use Admin\Service\AdminUserNavigationFactory;
use Admin\View\DatePicker;
use Admin\View\PhpInfo;
use Admin\View\TextEditor;
use Admin\View\UthandoFormElement;

return [
    'asset_manager' => [
        'resolver_configs' => [
            'collections' => [
                'js/admin.js' => [
                    'js/loading-overlay.min.js',
                    'js/jquery.datatable.js',
                    'js/admin-class.js',
                    'js/jquery.ajaxWidgetPanel.js',
                    'js/bootbox.min.js',
                ],
                'js/summernote.js' => [
                    'summernote.js',
                    'js/summernote-ext-highlight.js',
                    'js/summernote-ext-bootstrap.js',
                ],
                'css/admin.css' => [
                    'css/styles.css',
                    'css/summernote-ext-bootstrap.css',
                ],
                'js/bootstrap-datetimepicker.js' => [
                    'moment.js',
                    'bootstrap-datetimepicker.js',
                ],
                'css/codemirror.css' => [
                    'codemirror.css',
                    'css/show-hint.css',
                    'css/monokai.css',
                ],
                'js/codemirror.js' => [
                    'codemirror.js',
                    'js/show-hint.js',
                    'js/xml-hint.js',
                    'js/htmlmixed.js',
                    'js/htmlhint.js',
                    'js/xml.js',
                    'js/javascript.js' ,
                    'js/css.js',
                ],
            ],
            'map' => [
                'summernote.js' => 'https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js',

                'css/summernote.css' => 'https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css',
                'css/font/summernote.ttf' => 'https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/font/summernote.ttf',
                'css/font/summernote.woff' => 'https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/font/summernote.woff',

                'css/bootstrap-datetimepicker.css' => 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.45/css/bootstrap-datetimepicker.min.css',
                'bootstrap-datetimepicker.js' => 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.45/js/bootstrap-datetimepicker.min.js',

                'moment.js' => 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js',

                'codemirror.css' => 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.29.0/codemirror.css',
                'css/show-hint.css' => 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.29.0/addon/hint/show-hint.css',
                'css/monokai.css' => 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.29.0/theme/monokai.css',

                'codemirror.js' => 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.29.0/codemirror.js',
                'js/show-hint.js' => 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.29.0/addon/hint/show-hint.js',
                'js/xml-hint.js' => 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.29.0/addon/hint/xml-hint.js',
                'js/htmlmixed.js' => 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.29.0/mode/htmlmixed/htmlmixed.js',
                'js/htmlhint.js' => 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.29.0/addon/hint/html-hint.js',
                'js/xml.js' => 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.29.0/mode/xml/xml.js',
                'js/javascript.js' => 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.29.0/mode/javascript/javascript.js',
                'js/css.js' => 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.29.0/mode/css/css.js',
            ],
            'paths' => [
                'Admin' => __DIR__ . '/../public',
            ],
        ],
    ],
    'controllers' => [
        'invokables' => [
            IndexController::class => IndexController::class
        ],
    ],
    'service_manager' => [
        'factories' => [
            AdminNavigationFactory::class       => AdminNavigationFactory::class,
            AdminUserNavigationFactory::class   => AdminUserNavigationFactory::class,
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'phpInfo'               => PhpInfo::class,
            'uthandoFormElement'    => UthandoFormElement::class,
            'textEditor'            => TextEditor::class,
            'datePicker'            => DatePicker::class
        ],
        'invokables' => [
            PhpInfo::class              => PhpInfo::class,
            UthandoFormElement::class   => UthandoFormElement::class,
            TextEditor::class           => TextEditor::class,
            DatePicker::class           => DatePicker::class
        ],
    ],
    'view_manager' => [
        'template_map' => include __DIR__ . '/../template_map.php',
    ],
    'router' => [
        'routes' => [
            'admin' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/admin',
                    'defaults' => [
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => IndexController::class,
                        'action' => 'index',
                        'is-admin' => true,
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'admin' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route' => '/[:action]',
                            'constraints'   => [
                                'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                                'controller' => IndexController::class,
                                'action' => 'index',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'navigation' => [
        'default' => [
            'admin' => [
                'label' => 'Admin',
                'route' => 'admin',
                'resource' => 'menu:admin',
            ],
        ],
        'admin' => [
            'admin' => [
                'label' => 'Admin',
                'params' => [
                    'icon' => 'fa-tachometer',
                ],
                'route' => 'admin',
                'resource' => 'menu:admin',
                'pages' => [
                    'phpinfo' => [
                        'label' => 'PHP Info',
                        'route' => 'admin',
                        'resource' => 'menu:admin'
                    ],
                    'settings' => [
                        'label' => 'Settings',
                        'uri' => '#',
                        'resource' => 'menu:admin',
                    ],
                ],
            ],
        ],
        'admin-user' => [
            'profile' => [
                'label' => 'Edit Profile',
                'route' => 'admin/admin',
                'action' => 'profile',
                'resource' => 'menu:admin',
            ],
            'password' => [
                'label' => 'Change Password',
                'route' => 'admin/admin',
                'action' => 'password',
                'resource' => 'menu:admin',
            ],
            'logout' => [
                'label' => 'Logout',
                'route' => 'admin/admin',
                'action' => 'logout',
                'resource' => 'menu:admin',
            ],
        ],
    ],
];