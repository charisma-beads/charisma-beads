<?php

use Article\Controller\ArticleController;

return [
    'user' => [
        'acl' => [
            'roles' => [
                'guest' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                ArticleController::class => ['action' => ['view']],
                            ],
                            'resources' => ['article:guest'],
                        ],
                    ],
                ],
                'registered' => [
                    'privileges' => [
                        'allow' => [
                            'resources' => ['article:user'],
                        ],
                    ],
                ],
                'admin' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                ArticleController::class => ['action' => 'all'],
                            ],
                            'resources' => ['article:admin'],
                        ],
                    ],
                ],
            ],
            'resources' => [
                ArticleController::class,
                'article:guest',
                'article:user',
                'article:admin',
            ],
        ],
    ],
];
