<?php

return [
    'navigation' => [
        'admin' => [
            'menu' => [
                'label' => 'Menu',
                'params' => [
                    'icon' => 'fa-bars',
                ],
                'pages' => [
                    'add' => [
                        'label'      => 'Add Menu',
                        'action'     => 'add',
                        'route'      => 'admin/menu/edit',
                        'resource'   => 'menu:admin',
                        'visible'    => false,
                    ],
                    'edit' => [
                        'label'      => 'Edit Menu',
                        'action'     => 'edit',
                        'route'      => 'admin/menu/edit',
                        'resource'   => 'menu:admin',
                        'visible'    => false,
                    ],
                    'menu-item' => [
                        'label' => 'Menu Item',
                        'route' => 'admin/menu-item',
                        'pages' => [
                            'add' => [
                                'label'      => 'Add Menu Item',
                                'action'     => 'add',
                                'route'      => 'admin/menu-item/edit',
                                'resource'   => 'menu:admin',
                                'visible'    => false,
                            ],
                            'edit' => [
                                'label'      => 'Edit Menu Item',
                                'action'     => 'edit',
                                'route'      => 'admin/menu-item/edit',
                                'resource'   => 'menu:admin',
                                'visible'    => false,
                            ],
                        ],
                        'resource' => 'menu:admin',
                        'visible'    => false,
                    ],

                ],
                'route' => 'admin/menu',
                'resource' => 'menu:admin'
            ],
        ],
    ],
];
