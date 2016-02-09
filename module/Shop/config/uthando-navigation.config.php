<?php

return [
    'navigation' => [
        'user' => [
            'orders' => [
                'label' => 'My Orders',
                'route' => 'shop/order',
                'resource' => 'menu:user'
            ],
            'details' => [
                'label' => 'My Details',
                'route' => 'shop/customer',
                'resource' => 'menu:user',
            ],
            'address' => [
                'label' => 'My Addresses',
                'route' => 'shop/customer/address',
                'resource' => 'menu:user'
            ]
        ],
        'admin' => [
            'admin' => [
                'pages' => [
                    'settings' => [
                        'pages' => [
                            'shop-settings' => [
                                'label' => 'Shop',
                                'action' => 'index',
                                'route' => 'admin/shop/settings',
                                'resource' => 'menu:admin',
                            ],
                        ],
                    ],
                ],
            ],
            'shop' => [
                'label' => 'Shop',
                'params' => [
                    'icon' => 'fa-shopping-cart',
                ],
                'pages' => [
                    'overview' => [
                        'label' => 'Overview',
                        'action' => 'index',
                        'route' => 'admin/shop',
                        'resource' => 'menu:admin'
                    ],
                    'products' => [
                        'label' => 'Products',
                        'action' => 'index',
                        'route' => 'admin/shop/product',
                        'resource' => 'menu:admin',
                        'pages' => [
                            'list' => [
                                'label' => 'List All Products',
                                'action' => 'index',
                                'route' => 'admin/shop/product',
                                'resource' => 'menu:admin'
                            ],
                            'add' => [
                                'label' => 'Add New Product',
                                'action' => 'add',
                                'route' => 'admin/shop/product/edit',
                                'resource' => 'menu:admin'
                            ],
                            'categories' => [
                                'label' => 'Categories',
                                'action' => 'index',
                                'route' => 'admin/shop/category',
                                'resource' => 'menu:admin',
                                'pages' => [
                                    'list' => [
                                        'label' => 'List All Categories',
                                        'action' => 'index',
                                        'route' => 'admin/shop/category',
                                        'resource' => 'menu:admin'
                                    ],
                                    'add' => [
                                        'label' => 'Add New Category',
                                        'action' => 'add',
                                        'route' => 'admin/shop/category/edit',
                                        'resource' => 'menu:admin'
                                    ]
                                ]
                            ],
                            'sizes' => [
                                'label' => 'Product Sizes',
                                'action' => 'index',
                                'route' => 'admin/shop/product/size',
                                'resource' => 'menu:admin',
                                'pages' => [
                                    'list' => [
                                        'label' => 'List All Sizes',
                                        'action' => 'index',
                                        'route' => 'admin/shop/product/size',
                                        'resource' => 'menu:admin'
                                    ],
                                    'add' => [
                                        'label' => 'Add New Size',
                                        'action' => 'add',
                                        'route' => 'admin/shop/product/size/edit',
                                        'resource' => 'menu:admin'
                                    ]
                                ]
                            ],
                            'groups' => [
                                'label' => 'Groups',
                                'action' => 'index',
                                'route' => 'admin/shop/group',
                                'resource' => 'menu:admin',
                                'pages' => [
                                    'list' => [
                                        'label' => 'List All Group Prices',
                                        'action' => 'index',
                                        'route' => 'admin/shop/group',
                                        'resource' => 'menu:admin'
                                    ],
                                    'add' => [
                                        'label' => 'Add New Group Price',
                                        'action' => 'add',
                                        'route' => 'admin/shop/group/edit',
                                        'resource' => 'menu:admin'
                                    ]
                                ]
                            ],
                        ]
                    ],
                    'customers' => [
                        'label' => 'Customers',
                        'action' => 'index',
                        'route' => 'admin/shop/customer',
                        'resource' => 'menu:admin',
                        'pages' => [
                            'list' => [
                                'label' => 'List All Customers',
                                'action' => 'index',
                                'route' => 'admin/shop/customer',
                                'resource' => 'menu:admin'
                            ],
                            'add' => [
                                'label' => 'Add New Customer',
                                'action' => 'add',
                                'route' => 'admin/shop/customer/edit',
                                'resource' => 'menu:admin'
                            ]
                        ]
                    ],
                    'orders' => [
                        'label' => 'Orders',
                        'action' => 'index',
                        'route' => 'admin/shop/order',
                        'resource' => 'menu:admin',
                        'pages' => [
                            'list' => [
                                'label' => 'List All Orders',
                                'action' => 'index',
                                'route' => 'admin/shop/order',
                                'resource' => 'menu:admin'
                            ],
                            'add' => [
                                'label' => 'Add New Order',
                                'action' => 'add',
                                'route' => 'admin/shop/order/edit',
                                'resource' => 'menu:admin'
                            ]
                        ]
                    ],
                    'postage' => [
                        'label' => 'Postage',
                        'action' => 'index',
                        'route' => 'admin/shop/post',
                        'resource' => 'menu:admin',
                        'pages' => [
                            'zones' => [
                                'label' => 'Zones',
                                'action' => 'index',
                                'route' => 'admin/shop/post/zone',
                                'resource' => 'menu:admin',
                                'pages' => [
                                    'edit' => [
                                        'label' => 'List All Zones',
                                        'action' => 'index',
                                        'route' => 'admin/shop/post/zone',
                                        'resource' => 'menu:admin'
                                    ],
                                    'add' => [
                                        'label' => 'Add New Zone',
                                        'action' => 'add',
                                        'route' => 'admin/shop/post/zone/edit',
                                        'resource' => 'menu:admin'
                                    ]
                                ]
                            ],
                            'countries' => [
                                'label' => 'Countries',
                                'action' => 'index',
                                'route' => 'admin/shop/country',
                                'resource' => 'menu:admin',
                                'pages' => [
                                    'edit' => [
                                        'label' => 'List All Countries',
                                        'action' => 'index',
                                        'route' => 'admin/shop/country',
                                        'resource' => 'menu:admin'
                                    ],
                                    'add' => [
                                        'label' => 'Add New Country',
                                        'action' => 'add',
                                        'route' => 'admin/shop/country/edit',
                                        'resource' => 'menu:admin'
                                    ]
                                ]
                            ],
                            'levels' => [
                                'label' => 'Postage Levels',
                                'action' => 'index',
                                'route' => 'admin/shop/post/level',
                                'resource' => 'menu:admin',
                                'pages' => [
                                    'edit' => [
                                        'label' => 'List All Postage Levels',
                                        'action' => 'index',
                                        'route' => 'admin/shop/post/level',
                                        'resource' => 'menu:admin'
                                    ],
                                    'add' => [
                                        'label' => 'Add New Postage Level',
                                        'action' => 'add',
                                        'route' => 'admin/shop/post/level/edit',
                                        'resource' => 'menu:admin'
                                    ]
                                ]
                            ],
                            'costs' => [
                                'label' => 'Postage Costs',
                                'action' => 'index',
                                'route' => 'admin/shop/post/cost',
                                'resource' => 'menu:admin',
                                'pages' => [
                                    'edit' => [
                                        'label' => 'List All Postage Costs',
                                        'action' => 'index',
                                        'route' => 'admin/shop/post/cost',
                                        'resource' => 'menu:admin'
                                    ],
                                    'add' => [
                                        'label' => 'Add New Postage Cost',
                                        'action' => 'add',
                                        'route' => 'admin/shop/post/cost/edit',
                                        'resource' => 'menu:admin'
                                    ]
                                ]
                            ],
                            'units' => [
                                'label' => 'Postage Units',
                                'action' => 'index',
                                'route' => 'admin/shop/post/unit',
                                'resource' => 'menu:admin',
                                'pages' => [
                                    'edit' => [
                                        'label' => 'List All Postage Units',
                                        'action' => 'index',
                                        'route' => 'admin/shop/post/unit',
                                        'resource' => 'menu:admin'
                                    ],
                                    'add' => [
                                        'label' => 'Add New Postage Unit',
                                        'action' => 'add',
                                        'route' => 'admin/shop/post/unit/edit',
                                        'resource' => 'menu:admin'
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'tax' => [
                        'label' => 'Tax',
                        'action' => 'index',
                        'route' => 'admin/shop/tax',
                        'resource' => 'menu:admin',
                        'pages' => [
                            'rates' => [
                                'label' => 'Rates',
                                'action' => 'index',
                                'route' => 'admin/shop/tax/rate',
                                'resource' => 'menu:admin',
                                'pages' => [
                                    'edit' => [
                                        'label' => 'List All Tax Rates',
                                        'action' => 'index',
                                        'route' => 'admin/shop/tax/rate',
                                        'resource' => 'menu:admin'
                                    ],
                                    'add' => [
                                        'label' => 'Add New Tax Rate',
                                        'action' => 'add',
                                        'route' => 'admin/shop/tax/rate/edit',
                                        'resource' => 'menu:admin'
                                    ]
                                ]
                            ],
                            'codes' => [
                                'label' => 'Codes',
                                'action' => 'index',
                                'route' => 'admin/shop/tax/code',
                                'resource' => 'menu:admin',
                                'pages' => [
                                    'edit' => [
                                        'label' => 'List All Tax Codes',
                                        'action' => 'index',
                                        'route' => 'admin/shop/tax/code',
                                        'resource' => 'menu:admin'
                                    ],
                                    'add' => [
                                        'label' => 'Add New Tax Code',
                                        'action' => 'add',
                                        'route' => 'admin/shop/tax/code/edit',
                                        'resource' => 'menu:admin'
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'advert' => [
                        'label' => 'Adverts',
                        'action' => 'index',
                        'route' => 'admin/shop/advert',
                        'resource' => 'menu:admin',
                        'pages' => [
                            'list' => [
                                'label' => 'List All Adverts',
                                'action' => 'index',
                                'route' => 'admin/shop/advert',
                                'resource' => 'menu:admin'
                            ],
                            'add' => [
                                'label' => 'Add New Advert',
                                'action' => 'add',
                                'route' => 'admin/shop/advert/edit',
                                'resource' => 'menu:admin'
                            ]
                        ]
                    ],
                    'faq' => [
                        'label' => 'F.A.Q',
                        'action' => 'index',
                        'route' => 'admin/shop/faq',
                        'resource' => 'menu:admin',
                        'pages' => [
                            'list' => [
                                'label' => 'List All FAQs',
                                'action' => 'index',
                                'route' => 'admin/shop/faq',
                                'resource' => 'menu:admin'
                            ],
                            'add' => [
                                'label' => 'Add New FAQ',
                                'action' => 'add',
                                'route' => 'admin/shop/faq/edit',
                                'resource' => 'menu:admin'
                            ]
                        ]
                    ],
                    'shop-settings' => [
                        'label' => 'Settings',
                        'action' => 'index',
                        'route' => 'admin/shop/settings',
                        'resource' => 'menu:admin',
                    ],
                ],
                'route' => 'admin/shop',
                'resource' => 'menu:admin'
            ],
        ],
    ],
];
