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
                                'label' => 'List Products',
                                'action' => 'index',
                                'route' => 'admin/shop/product',
                                'resource' => 'menu:admin',
                                'pages' => [
                                    'edit' => [
                                        'label' => 'Edit Product',
                                        'action' => 'edit',
                                        'route' => 'admin/shop/product/edit',
                                        'resource' => 'menu:admin',
                                        'visible' => false,
                                    ],
                                    'add' => [
                                        'label' => 'Add Product',
                                        'action' => 'add',
                                        'route' => 'admin/shop/product/edit',
                                        'resource' => 'menu:admin',
                                        'visible' => false,
                                    ],
                                ],
                            ],
                            'categories' => [
                                'label' => 'Categories',
                                'action' => 'index',
                                'route' => 'admin/shop/category',
                                'resource' => 'menu:admin',
                                'pages' => [
                                    'edit' => [
                                        'label' => 'Edit Category',
                                        'action' => 'edit',
                                        'route' => 'admin/shop/category/edit',
                                        'resource' => 'menu:admin',
                                        'visible' => false,
                                    ],
                                    'add' => [
                                        'label' => 'Add Category',
                                        'action' => 'add',
                                        'route' => 'admin/shop/category/edit',
                                        'resource' => 'menu:admin',
                                        'visible' => false,
                                    ],
                                ],
                            ],
                            'sizes' => [
                                'label' => 'Product Sizes',
                                'action' => 'index',
                                'route' => 'admin/shop/product/size',
                                'resource' => 'menu:admin',
                                'pages' => [
                                    'edit' => [
                                        'label' => 'Edit Product Size',
                                        'action' => 'edit',
                                        'route' => 'admin/shop/product/size/edit',
                                        'resource' => 'menu:admin',
                                        'visible' => false,
                                    ],
                                    'add' => [
                                        'label' => 'Add Product Size',
                                        'action' => 'add',
                                        'route' => 'admin/shop/product/size/edit',
                                        'resource' => 'menu:admin',
                                        'visible' => false,
                                    ],
                                ],
                            ],
                            'groups' => [
                                'label' => 'Groups',
                                'action' => 'index',
                                'route' => 'admin/shop/group',
                                'resource' => 'menu:admin',
                                'pages' => [
                                    'edit' => [
                                        'label' => 'Edit Group',
                                        'action' => 'edit',
                                        'route' => 'admin/shop/group/edit',
                                        'resource' => 'menu:admin',
                                        'visible' => false,
                                    ],
                                    'add' => [
                                        'label' => 'Add Group',
                                        'action' => 'add',
                                        'route' => 'admin/shop/group/edit',
                                        'resource' => 'menu:admin',
                                        'visible' => false,
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'customers' => [
                        'label' => 'Customers',
                        'action' => 'index',
                        'route' => 'admin/shop/customer',
                        'resource' => 'menu:admin',
                        'pages' => [
                            'edit' => [
                                'label' => 'Edit Customer',
                                'action' => 'edit',
                                'route' => 'admin/shop/customer/edit',
                                'resource' => 'menu:admin',
                                'visible' => false,
                            ],
                            'add' => [
                                'label' => 'Add Customer',
                                'action' => 'add',
                                'route' => 'admin/shop/customer/edit',
                                'resource' => 'menu:admin',
                                'visible' => false,
                            ],
                        ],
                    ],
                    'orders' => [
                        'label' => 'Orders',
                        'action' => 'index',
                        'route' => 'admin/shop/order',
                        'resource' => 'menu:admin',
                        'pages' => [
                            'edit' => [
                                'label' => 'Edit Orders',
                                'action' => 'index',
                                'route' => 'admin/shop/order/edit',
                                'resource' => 'menu:admin',
                                'visible' => false,
                            ],
                            'create' => [
                                'label' => 'Create Order',
                                'action' => 'create',
                                'route' => 'admin/shop/order/create',
                                'resource' => 'menu:admin',
                                'visible' => false,
                            ],
                            'add' => [
                                'label' => 'Add New Order',
                                'action' => 'add',
                                'route' => 'admin/shop/order/edit',
                                'resource' => 'menu:admin',
                                'visible' => false,
                            ],
                        ],
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
                                        'label' => 'Edit Zone',
                                        'action' => 'edit',
                                        'route' => 'admin/shop/post/zone/edit',
                                        'resource' => 'menu:admin',
                                        'visible' => false,
                                    ],
                                    'add' => [
                                        'label' => 'Add New Zone',
                                        'action' => 'add',
                                        'route' => 'admin/shop/post/zone/edit',
                                        'resource' => 'menu:admin',
                                        'visible' => false,
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
                                        'label' => 'Edit Country',
                                        'action' => 'edit',
                                        'route' => 'admin/shop/country/edit',
                                        'resource' => 'menu:admin',
                                        'visible' => false,
                                    ],
                                    'add' => [
                                        'label' => 'Add New Country',
                                        'action' => 'add',
                                        'route' => 'admin/shop/country/edit',
                                        'resource' => 'menu:admin',
                                        'visible' => false,
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
                                        'label' => 'Edit Postage Level',
                                        'action' => 'edit',
                                        'route' => 'admin/shop/post/level/edit',
                                        'resource' => 'menu:admin',
                                        'visible' => false,
                                    ],
                                    'add' => [
                                        'label' => 'Add New Postage Level',
                                        'action' => 'add',
                                        'route' => 'admin/shop/post/level/edit',
                                        'resource' => 'menu:admin',
                                        'visible' => false,
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
                                        'label' => 'Edit Postage Cost',
                                        'action' => 'edit',
                                        'route' => 'admin/shop/post/cost/edit',
                                        'resource' => 'menu:admin',
                                        'visible' => false,
                                    ],
                                    'add' => [
                                        'label' => 'Add New Postage Cost',
                                        'action' => 'add',
                                        'route' => 'admin/shop/post/cost/edit',
                                        'resource' => 'menu:admin',
                                        'visible' => false,
                                    ],
                                ],
                            ],
                            'units' => [
                                'label' => 'Postage Units',
                                'action' => 'index',
                                'route' => 'admin/shop/post/unit',
                                'resource' => 'menu:admin',
                                'pages' => [
                                    'edit' => [
                                        'label' => 'Edit Postage Unit',
                                        'action' => 'edit',
                                        'route' => 'admin/shop/post/unit/edit',
                                        'resource' => 'menu:admin',
                                        'visible' => false,
                                    ],
                                    'add' => [
                                        'label' => 'Add New Postage Unit',
                                        'action' => 'add',
                                        'route' => 'admin/shop/post/unit/edit',
                                        'resource' => 'menu:admin',
                                        'visible' => false,
                                    ],
                                ],
                            ],
                        ],
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
                                        'label' => 'Edit Tax Rate',
                                        'action' => 'edit',
                                        'route' => 'admin/shop/tax/rate/edit',
                                        'resource' => 'menu:admin',
                                        'visible' => false,
                                    ],
                                    'add' => [
                                        'label' => 'Add New Tax Rate',
                                        'action' => 'add',
                                        'route' => 'admin/shop/tax/rate/edit',
                                        'resource' => 'menu:admin',
                                        'visible' => false,
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
                                        'label' => 'Edit Tax Code',
                                        'action' => 'edit',
                                        'route' => 'admin/shop/tax/code/edit',
                                        'resource' => 'menu:admin',
                                        'visible' => false,
                                    ],
                                    'add' => [
                                        'label' => 'Add New Tax Code',
                                        'action' => 'add',
                                        'route' => 'admin/shop/tax/code/edit',
                                        'resource' => 'menu:admin',
                                        'visible' => false,
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
                                'label' => 'Edit Advert',
                                'action' => 'edit',
                                'route' => 'admin/shop/advert/edit',
                                'resource' => 'menu:admin',
                                'visible' => false,
                            ],
                            'add' => [
                                'label' => 'Add New Advert',
                                'action' => 'add',
                                'route' => 'admin/shop/advert/edit',
                                'resource' => 'menu:admin',
                                'visible' => false,
                            ],
                        ],
                    ],
                    'faq' => [
                        'label' => 'F.A.Q',
                        'action' => 'index',
                        'route' => 'admin/shop/faq',
                        'resource' => 'menu:admin',
                        'pages' => [
                            'list' => [
                                'label' => 'Edit FAQ',
                                'action' => 'edit',
                                'route' => 'admin/shop/faq/edit',
                                'resource' => 'menu:admin',
                                'visible' => false,
                            ],
                            'add' => [
                                'label' => 'Add New FAQ',
                                'action' => 'add',
                                'route' => 'admin/shop/faq/edit',
                                'resource' => 'menu:admin',
                                'visible' => false,
                            ],
                        ],
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
