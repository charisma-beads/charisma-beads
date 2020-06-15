<?php

namespace Shop;

return [
    'router' => [
        'routes' => [
            'shop' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/shop',
                    'defaults' => [
                        '__NAMESPACE__' => 'Shop\Controller',
                        'controller' => Controller\ShopController::class,
                        'action' => 'shop-front',
                        'force-ssl' => 'ssl'
                    ]
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'catalog' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '[/:categoryIdent]',
                            'constraints' => [
                                'categoryIdent' => '[a-zA-Z0-9][a-zA-Z0-9_-]*'
                            ],
                            'defaults' => [
                                'controller' => Controller\CatalogController::class,
                                'action' => 'index',
                                'categoryIdent' => '',
                            ]
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'product' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/[:productIdent]',
                                    'constraints' => [
                                        'productIdent' => '[a-zA-Z0-9][a-zA-Z0-9_-]*'
                                    ],
                                    'defaults' => [
                                        'action' => 'view',
                                        'productIdent' => '',
                                    ]
                                ]
                            ],
                            'page' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/page/[:page]',
                                    'constraints' => [
                                        'page' => '\d+'
                                    ],
                                    'defaults' => [
                                        'page' => 1,
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'search' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/search',
                            'defaults' => [
                                'controller' => Controller\CatalogController::class,
                                'action' => 'search',
                            ]
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'page' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/page/[:page]',
                                    'constraints' => [
                                        'page' => '\d+'
                                    ],
                                    'defaults' => [
                                        'page' => 1,
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'cart' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/cart/[:action[/[:id]]]',
                            'constraints' => [
                                'action' => '[a-zA-Z0-9][a-zA-Z0-9_-]*',
                                'id' => '\d+'
                            ],
                            'defaults' => [
                                'controller' => Controller\CartController::class,
                                'action' => 'view',
                            ]
                        ]
                    ],
                    'checkout' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/checkout[/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z0-9][a-zA-Z0-9_-]*'
                            ],
                            'defaults' => [
                                'controller' => Controller\CheckoutController::class,
                                'action' => 'index',
                                'force-ssl' => 'ssl'
                            ]
                        ]
                    ],
                    'customer' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/customer[/]',
                            'defaults' => [
                                'controller' => Controller\CustomerController::class,
                                'action' => 'my-details',
                                'force-ssl' => 'ssl'
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'address' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => 'address[/][:action[/[:id][/[:return]]]]',
                                    'constraints' => [
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id' => '\d+',
                                    ],
                                    'defaults' => [
                                        'controller' => Controller\CustomerAddressController::class,
                                        'action' => 'my-addresses',
                                        'force-ssl' => 'ssl'
                            		],
                                ],
                            ],
                        ],
                    ],
                    'country' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/country/province',
                            'defaults' => [
                                'controller' => Controller\CountryProvinceController::class,
                                'action' => 'country-province-list',
                            ],
                        ],
                    ],
                    'order' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/order[/]',
                            'defaults' => [
                                'controller' => Controller\OrderController::class,
                                'action' => 'my-orders',
                                'force-ssl' => 'ssl'
                            ]
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'view' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => 'view/[:orderId]',
                                    'constraints' => [
                                        'orderId' => '\d+'
                                    ],
                                    'defaults' => [
                                        'action' => 'view',
                                        'force-ssl' => 'ssl'
                                    ]
                                ]
                            ],
                            'print' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => 'print/[:orderId]',
                                    'constraints' => [
                                        'orderId' => '\d+'
                                    ],
                                    'defaults' => [
                                        'action' => 'print',
                                        'force-ssl' => 'ssl'
                                    ]
                                ]
                            ],
                            'page' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => 'page/[:page]',
                                    'constraints' => [
                                        'page' => '\d+'
                                    ],
                                    'defaults' => [
                                        'page' => 1,
                                        'force-ssl' => 'ssl'
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'payment' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/payment',
                            'defaults' => [
                                'controller' => Controller\PaymentController::class,
                                'force-ssl' => 'ssl'
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'default' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/:paymentOption',
                                    'constraints' => [
                                        'paymentOption' => '[a-zA-Z][a-zA-Z-]*',
                                    ],
                                    'defaults' => [
                                        'action' => 'index',
                                    ],
                                ],
                            ],
                            'process-credit-card' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/process-credit-card/:orderId',
                                    'constraints' => [
                                        'orderId' => '\d+',
                                    ],
                                    'defaults' => [
                                        'action' => 'process-credit-card',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'paypal' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/paypal[/:action[/:orderId]]',
                            'constraints' => [
                                'action' => '[a-zA-Z0-9][a-zA-Z0-9_-]*',
                                'orderId' => '\d+',
                            ],
                            'defaults' => [
                                'controller' => Controller\PaypalController::class,
                                'force-ssl' => 'ssl',
                                'orderId' => 0,
                            ],
                        ],
                    ],
                    'faq' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/faq',
                            'defaults' => [
                                'controller' => Controller\FaqController::class,
                                'action' => 'faq',
                                'force-ssl' => 'ssl',
                            ]
                        ]
                    ],
                    'voucher' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/add-voucher',
                            'defaults' => [
                                'controller' => Controller\VoucherCodesController::class,
                                'action' => 'add-voucher',
                                'force-ssl' => 'ssl',
                            ],
                        ],
                    ],
                ],
            ],
            'admin' => [
                'child_routes' => [
                    'shop' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/shop',
                            'defaults' => [
                                '__NAMESPACE__' => 'Shop\Controller',
                                'controller' => Controller\ShopController::class,
                                'action' => 'index',
                                'force-ssl' => 'ssl'
                            ]
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'advert' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/advert',
                                    'defaults' => [
                                        'controller' => Controller\AdvertController::class,
                                        'action' => 'index',
                                        'force-ssl' => 'ssl'
                                    ]
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'edit' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/[:action[/id/[:id]]]',
                                            'constraints' => [
                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'edit',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ],
                                    'page' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/page/[:page]',
                                            'constraints' => [
                                                'page' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'list',
                                                'page' => 1,
                                                'force-ssl' => 'ssl'
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                            'faq' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/faq',
                                    'defaults' => [
                                        'controller' => Controller\FaqController::class,
                                        'action' => 'index',
                                        'force-ssl' => 'ssl'
                                    ],
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'edit' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/[:action[/id/[:id]]]',
                                            'constraints' => [
                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'edit',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ],
                                    'page' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/page/[:page]',
                                            'constraints' => [
                                                'page' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'list',
                                                'page' => 1,
                                                'force-ssl' => 'ssl'
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                            'product' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/product',
                                    'defaults' => [
                                        'controller' => Controller\ProductController::class,
                                        'action' => 'index',
                                        'force-ssl' => 'ssl'
                                    ]
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'edit' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/[:action[/id/[:id]]]',
                                            'constraints' => [
                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'edit',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ],
                                    'search' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/search[/][:search]',
                                            'constraints' => [
                                                'search' => '[a-zA-Z0-9][a-zA-Z0-9.%_-]*',
                                            ],
                                            'defaults' => [
                                                'action' => 'search',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ],
                                    'image' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/image[/][:action[/[:id]]]',
                                            'constraints' => [
                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id' => '\d+',
                                            ],
                                            'defaults' => [
                                                'controller' => Controller\ProductImageController::class,
                                                'action' => 'list',
                                                'force-ssl' => 'ssl'
                                            ],
                                        ],
                                    ],
                                    'option' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/option[/][:action[/[:id]]]',
                                            'constraints' => [
                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id' => '\d+',
                                            ],
                                            'defaults' => [
                                                'controller' => Controller\ProductOptionController::class,
                                                'action' => 'list',
                                                'force-ssl' => 'ssl'
                                            ],
                                        ],
                                    ],
                                    'size' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/size',
                                            'defaults' => [
                                                'controller' => Controller\ProductSizeController::class,
                                                'action' => 'index',
                                                'force-ssl' => 'ssl'
                                            ],
                                        ],
                                        'may_terminate' => true,
                                        'child_routes' => [
                                            'edit' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/[:action[/id/[:id]]]',
                                                    'constraints' => [
                                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                        'id' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'edit',
                                                        'force-ssl' => 'ssl'
                                                    ],
                                                ],
                                            ],
                                            'page' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/page/[:page]',
                                                    'constraints' => [
                                                        'page' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'list',
                                                        'page' => 1,
                                                        'force-ssl' => 'ssl'
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                    'page' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/page/[:page]',
                                            'constraints' => [
                                                'page' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'list',
                                                'page' => 1,
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            'category' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/category',
                                    'defaults' => [
                                        'controller' => Controller\ProductCategoryController::class,
                                        'action' => 'index',
                                        'force-ssl' => 'ssl'
                                    ]
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'edit' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/[:action[/id/[:id]]]',
                                            'constraints' => [
                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'edit',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ],
                                    'page' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/page/[:page]',
                                            'constraints' => [
                                                'page' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'list',
                                                'page' => 1,
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            'group' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/group',
                                    'defaults' => [
                                        'controller' => Controller\ProductGroupController::class,
                                        'action' => 'index',
                                        'force-ssl' => 'ssl'
                                    ]
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'edit' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/[:action[/id/[:id]]]',
                                            'constraints' => [
                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'edit',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ],
                                    'page' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/page/[:page]',
                                            'constraints' => [
                                                'page' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'list',
                                                'page' => 1,
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            'country' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/country',
                                    'defaults' => [
                                        'controller' => Controller\CountryController::class,
                                        'action' => 'index',
                                        'force-ssl' => 'ssl'
                                    ]
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'edit' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/[:action[/id/[:id]]]',
                                            'constraints' => [
                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'edit',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ],
                                    'province' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/province[/][:action][/[:id]]',
                                            'constraints' => [
                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id' => '\d+',
                                            ],
                                            'defaults' => [
                                                'controller' => Controller\CountryProvinceController::class,
                                                'action' => 'list',
                                                'force-ssl' => 'ssl'
                                            ],
                                        ],
                                    ],
                                    'page' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/page/[:page]',
                                            'constraints' => [
                                                'page' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'list',
                                                'page' => 1,
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            'customer' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/customer',
                                    'defaults' => [
                                        'controller' => Controller\CustomerController::class,
                                        'action' => 'index',
                                        'force-ssl' => 'ssl'
                                    ],
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'edit' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/[:action[/id/[:id]]]',
                                            'constraints' => [
                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id' => '\d+',
                                            ],
                                            'defaults' => [
                                                'action' => 'edit',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ],
                                    'address' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/address[/][:action[/[:id]]]',
                                            'constraints' => [
                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id' => '\d+',
                                            ],
                                            'defaults' => [
                                                'controller' => Controller\CustomerAddressController::class,
                                                'action' => 'list',
                                                'force-ssl' => 'ssl'
                                            ],
                                        ],
                                    ],
                                    'page' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/page/[:page]',
                                            'constraints' => [
                                                'page' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'list',
                                                'page' => 1,
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            'order' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/order',
                                    'defaults' => [
                                        'controller' => Controller\OrderController::class,
                                        'action' => 'index',
                                        'force-ssl' => 'ssl'
                                    ]
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'create' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/create/[:action][/id/[:id]]',
                                            'contraints' => [
                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id' => '\d+'
                                            ],
                                            'defaults' => [
                                                'controller' => Controller\CreateOrderController::class,
                                                'force-ssl' => 'ssl',
                                                'action' => 'create',
                                            ]
                                        ],
                                    ],
                                    'edit' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/[:action[/id/[:id]]]',
                                            'constraints' => [
                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'edit',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ],
                                    'page' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/page/[:page]',
                                            'constraints' => [
                                                'page' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'list',
                                                'page' => 1,
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ]
                                ],
                            ],
                            'post' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/post',
                                    'defaults' => [
                                        'controller' => Controller\PostCostController::class,
                                        'action' => 'index',
                                        'force-ssl' => 'ssl'
                                    ]
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'cost' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/cost',
                                            'defaults' => [
                                                'controller' => Controller\PostCostController::class,
                                                'action' => 'index',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ],
                                        'may_terminate' => true,
                                        'child_routes' => [
                                            'edit' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/[:action[/id/[:id]]]',
                                                    'constraints' => [
                                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                        'id' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'edit',
                                                        'force-ssl' => 'ssl'
                                                    ]
                                                ]
                                            ],
                                            'page' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/page/[:page]',
                                                    'constraints' => [
                                                        'page' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'list',
                                                        'page' => 1,
                                                        'force-ssl' => 'ssl'
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ],
                                    'level' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/level',
                                            'defaults' => [
                                                'controller' => Controller\PostLevelController::class,
                                                'action' => 'index',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ],
                                        'may_terminate' => true,
                                        'child_routes' => [
                                            'edit' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/[:action[/id/[:id]]]',
                                                    'constraints' => [
                                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                        'id' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'edit',
                                                        'force-ssl' => 'ssl'
                                                    ]
                                                ]
                                            ],
                                            'page' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/page/[:page]',
                                                    'constraints' => [
                                                        'page' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'list',
                                                        'page' => 1,
                                                        'force-ssl' => 'ssl'
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ],
                                    'zone' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/zone',
                                            'defaults' => [
                                                'controller' => Controller\PostZoneController::class,
                                                'action' => 'index',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ],
                                        'may_terminate' => true,
                                        'child_routes' => [
                                            'edit' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/[:action[/id/[:id]]]',
                                                    'constraints' => [
                                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                        'id' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'edit',
                                                        'force-ssl' => 'ssl'
                                                    ]
                                                ]
                                            ],
                                            'page' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/page/[:page]',
                                                    'constraints' => [
                                                        'page' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'list',
                                                        'page' => 1,
                                                        'force-ssl' => 'ssl'
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ],
                                    'unit' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/unit',
                                            'defaults' => [
                                                'controller' => Controller\PostUnitController::class,
                                                'action' => 'index',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ],
                                        'may_terminate' => true,
                                        'child_routes' => [
                                            'edit' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/[:action[/id/[:id]]]',
                                                    'constraints' => [
                                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                        'id' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'edit',
                                                        'force-ssl' => 'ssl'
                                                    ]
                                                ]
                                            ],
                                            'page' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/page/[:page]',
                                                    'constraints' => [
                                                        'page' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'list',
                                                        'page' => 1,
                                                        'force-ssl' => 'ssl'
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            'tax' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/tax',
                                    'defaults' => [
                                        'controller' => Controller\TaxCodeController::class,
                                        'action' => 'index',
                                        'force-ssl' => 'ssl'
                                    ]
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'code' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/code',
                                            'defaults' => [
                                                'controller' => Controller\TaxCodeController::class,
                                                'action' => 'index',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ],
                                        'may_terminate' => true,
                                        'child_routes' => [
                                            'edit' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/[:action[/id/[:id]]]',
                                                    'constraints' => [
                                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                        'id' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'edit',
                                                        'force-ssl' => 'ssl'
                                                    ]
                                                ]
                                            ],
                                            'page' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/page/[:page]',
                                                    'constraints' => [
                                                        'page' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'list',
                                                        'page' => 1,
                                                        'force-ssl' => 'ssl'
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ],
                                    'rate' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/rate',
                                            'defaults' => [
                                                'controller' => Controller\TaxRateController::class,
                                                'action' => 'index',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ],
                                        'may_terminate' => true,
                                        'child_routes' => [
                                            'edit' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/[:action[/id/[:id]]]',
                                                    'constraints' => [
                                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                        'id' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'edit',
                                                        'force-ssl' => 'ssl'
                                                    ],
                                                ],
                                            ],
                                            'page' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/page/[:page]',
                                                    'constraints' => [
                                                        'page' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'list',
                                                        'page' => 1,
                                                        'force-ssl' => 'ssl'
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                            'paypal' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/paypal[/:action[/:paymentId]]',
                                    'constraints' => [
                                        'action' => '[a-zA-Z0-9][a-zA-Z0-9_-]*',
                                        'paymentId' => '[a-zA-Z0-9][a-zA-Z0-9-]*',
                                    ],
                                    'defaults' => [
                                        'controller' => Controller\PaypalController::class,
                                        'force-ssl' => 'ssl',
                                        'paymentId' => '',
                                    ],
                                ],
                            ],
                            'report' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/report[/:action[/:file]]',
                                    'constraints' => [
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    ],
                                    'defaults' => [
                                        'controller' => Controller\ReportController::class,
                                        'action' => 'index',
                                        'force-ssl' => 'ssl'
                                    ]
                                ],
                                'may_terminate' => true,
                            ],
                            'settings' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/settings[/:action]',
                                    'constraints' => [
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    ],
                                    'defaults' => [
                                        'controller' => Controller\SettingsController::class,
                                        'action' => 'index',
                                        'force-ssl' => 'ssl'
                                    ]
                                ],
                                'may_terminate' => true,
                            ],
                            'voucher' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/voucher',
                                    'defaults' => [
                                        'controller' => Controller\VoucherAdminController::class,
                                        'action' => 'index',
                                        'force-ssl' => 'ssl'
                                    ],
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'edit' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/[:action[/id/[:id]]]',
                                            'constraints' => [
                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'edit',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ],
                                    'page' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/page/[:page]',
                                            'constraints' => [
                                                'page' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'list',
                                                'page' => 1,
                                                'force-ssl' => 'ssl'
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]
    ],
    'console' => [
        'router' => [
            'routes' => [
                'shop/cart/gc' => [
                    'options' => [
                        'route' => 'shopping-cart gc',
                        'defaults' => array(
                            '__NAMESPACE__' => 'Shop\Controller',
                            'controller' => Controller\ConsoleController::class,
                            'action' => 'gc'
                        ),
                    ],
                ],
            ],
        ],
    ],
];
