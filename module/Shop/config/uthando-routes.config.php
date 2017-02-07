<?php

return [
    'router' => [
        'routes' => [
            'shop' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/shop',
                    'defaults' => [
                        '__NAMESPACE__' => 'Shop\Controller',
                        'controller' => 'Shop',
                        'action' => 'shop-front',
                        'force-ssl' => 'http'
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
                                'controller' => 'Catalog',
                                'action' => 'index',
                                'categoryIdent' => '',
                                'force-ssl' => 'http'
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
                                        'force-ssl' => 'http'
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
                                        'force-ssl' => 'http'
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
                                'controller' => 'Catalog',
                                'action' => 'search',
                                'force-ssl' => 'http'
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
                                        'force-ssl' => 'http'
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
                                'controller' => 'Cart',
                                'action' => 'view',
                                'force-ssl' => 'http'
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
                                'controller' => 'Checkout',
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
                                'controller' => 'Customer',
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
                                        'controller' => 'Customer\Address',
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
                                'controller' => 'Country\Province',
                                'action' => 'country-province-list',
                                'force-ssl' => 'http',
                            ],
                        ],
                    ],
                    'order' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/order[/]',
                            'defaults' => [
                                'controller' => 'Order',
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
                                'controller' => 'Payment',
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
                                'controller' => 'Paypal',
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
                                'controller' => 'Faq',
                                'action' => 'faq',
                                'force-ssl' => 'ssl',
                            ]
                        ]
                    ]
                ]
            ],
            'admin' => [
                'child_routes' => [
                    'shop' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/shop',
                            'defaults' => [
                                '__NAMESPACE__' => 'Shop\Controller',
                                'controller' => 'Shop',
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
                                        'controller' => 'Advert',
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
                                        'controller' => 'Faq',
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
                                        'controller' => 'Product',
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
                                                'controller' => 'Product\Image',
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
                                                'controller' => 'Product\Option',
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
                                                'controller' => 'Product\Size',
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
                                        'controller' => 'Product\Category',
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
                                        'controller' => 'Product\Group',
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
                                        'controller' => 'Country',
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
                                                'controller' => 'Country\Province',
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
                                        'controller' => 'Customer',
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
                                                'controller' => 'Customer\Address',
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
                                        'controller' => 'Order',
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
                                                'controller' => 'Order\CreateOrder',
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
                                        'controller' => 'Post\Cost',
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
                                                'controller' => 'Post\Cost',
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
                                                'controller' => 'Post\Level',
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
                                                'controller' => 'Post\Zone',
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
                                                'controller' => 'Post\Unit',
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
                                        'controller' => 'Tax\Code',
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
                                                'controller' => 'Tax\Code',
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
                                                'controller' => 'Tax\Rate',
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
                                        'controller' => 'Paypal',
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
                                        'controller' => 'Report',
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
                                        'controller' => 'Settings',
                                        'action' => 'index',
                                        'force-ssl' => 'ssl'
                                    ]
                                ],
                                'may_terminate' => true,
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
                            '__NAMESPACE__' => 'Shop\Controller\Cart',
                            'controller' => 'Console',
                            'action' => 'gc'
                        ),
                    ],
                ],
            ],
        ],
    ],
];
