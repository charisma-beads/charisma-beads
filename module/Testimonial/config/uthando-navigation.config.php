<?php

return [
    'navigation' => [
        'admin' => [
            'testimonial' => [
                'label' => 'Testimonials',
                'params' => [
                    'icon' => 'fa-comment',
                ],
                'pages' => [
                    'list' => [
                        'label'     => 'List Testimonials',
                        'action'    => 'index',
                        'route'     => 'admin/testimonial',
                        'resource'  => 'menu:admin',
                        'visible'   => false,
                    ],
                    'add' => [
                        'label'     => 'Add Testimonial',
                        'action'    => 'add',
                        'route'     => 'admin/testimonial/edit',
                        'resource'  => 'menu:admin',
                        'visible'   => false,
                    ],
                    'edit' => [
                        'label'     => 'Edit Testimonial',
                        'action'    => 'edit',
                        'route'     => 'admin/testimonial/edit',
                        'resource'  => 'menu:admin',
                        'visible'   => false,
                    ],
                ],
                'route' => 'admin/testimonial',
                'resource' => 'menu:admin'
            ],
        ],
    ],
];
