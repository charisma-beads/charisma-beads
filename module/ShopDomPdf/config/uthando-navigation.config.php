<?php

return [
    'navigation' => [
        'admin' => [
            'admin' => [
                'pages' => [
                    'settings' => [
                        'pages' => [
                            'dompdf-settings' => [
                                'label' => 'ShopDomPdf',
                                'action' => 'index',
                                'route' => 'admin/dompdf',
                                'resource' => 'menu:admin',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
