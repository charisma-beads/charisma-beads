<?php

return [
    'navigation' => [
        'user' => [
            'update_subscription' => [
                'label'     => 'Newsletter Preferences',
                'route'     => 'newsletter/update',
                'resource'  => 'menu:user',
            ],
        ],
        'admin' => [
            'newsletter' => [
                'label' => 'Newsletter',
                'params' => [
                    'icon' => 'fa-envelope-o',
                ],
                'route' => 'admin/newsletter',
                'resource' => 'menu:admin',
                'pages' => [
                    'list' => [
                        'label'     => 'List Newsletters',
                        'action'    => 'index',
                        'route'     => 'admin/newsletter',
                        'resource'  => 'menu:admin'
                    ],
                    'add' => [
                        'label'     => 'Add Newsletter',
                        'action'    => 'add',
                        'route'     => 'admin/newsletter/edit',
                        'resource'  => 'menu:admin',
                        'visible'   => false,
                    ],
                    'edit' => [
                        'label'     => 'Edit Newsletter',
                        'action'    => 'edit',
                        'route'     => 'admin/newsletter/edit',
                        'resource'  => 'menu:admin',
                        'visible'   => false,
                    ],
                    'messages' => [
                        'label' => 'Messages',
                        'route' => 'admin/newsletter/message',
                        'resource' => 'menu:admin',
                        'pages' => [
                            'list' => [
                                'label'     => 'List Messages',
                                'action'    => 'index',
                                'route'     => 'admin/newsletter/message',
                                'resource'  => 'menu:admin',
                                'visible'   => false,
                            ],
                            'add' => [
                                'label'     => 'Add Message',
                                'action'    => 'add',
                                'route'     => 'admin/newsletter/message/edit',
                                'resource'  => 'menu:admin',
                                'visible'   => false,
                            ],
                            'edit' => [
                                'label'     => 'Edit Message',
                                'action'    => 'edit',
                                'route'     => 'admin/newsletter/message/edit',
                                'resource'  => 'menu:admin',
                                'visible'   => false,
                            ],
                        ],
                    ],
                    'subscribers' => [
                        'label' => 'Subscribers',
                        'route' => 'admin/newsletter/subscriber',
                        'resource' => 'menu:admin',
                        'pages' => [
                            'list' => [
                                'label'     => 'List Subscribers',
                                'action'    => 'index',
                                'route'     => 'admin/newsletter/subscriber',
                                'resource'  => 'menu:admin',
                                'visible'   => false,
                            ],
                            'add' => [
                                'label'     => 'Add Subscriber',
                                'action'    => 'add',
                                'route'     => 'admin/newsletter/subscriber/edit',
                                'resource'  => 'menu:admin',
                                'visible'   => false,
                            ],
                            'edit' => [
                                'label'     => 'Edit Subscriber',
                                'action'    => 'edit',
                                'route'     => 'admin/newsletter/subscriber/edit',
                                'resource'  => 'menu:admin',
                                'visible'   => false,
                            ],
                        ],
                    ],
                    'templates' => [
                        'label' => 'Templates',
                        'route' => 'admin/newsletter/template',
                        'resource' => 'menu:admin',
                        'pages' => [
                            'list' => [
                                'label'     => 'List Templates',
                                'action'    => 'index',
                                'route'     => 'admin/newsletter/template',
                                'resource'  => 'menu:admin',
                                'visible'   => false,
                            ],
                            'add' => [
                                'label'     => 'Add Template',
                                'action'    => 'add',
                                'route'     => 'admin/newsletter/template/edit',
                                'resource'  => 'menu:admin',
                                'visible'   => false,
                            ],
                            'edit' => [
                                'label'     => 'Edit Template',
                                'action'    => 'edit',
                                'route'     => 'admin/newsletter/template/edit',
                                'resource'  => 'menu:admin',
                                'visible'   => false,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
