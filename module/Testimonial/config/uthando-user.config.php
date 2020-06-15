<?php

use Testimonial\Controller\TestimonialController;

return [
    'user' => [
        'acl' => [
            'roles' => [
                'guest' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                TestimonialController::class => ['action' => ['view']],
                            ],
                        ],
                    ],
                ],
                'admin' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                TestimonialController::class => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                TestimonialController::class,
            ],
        ],
    ],
];
