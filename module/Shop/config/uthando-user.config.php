<?php

return [
    'uthando_user' => [
        'acl' => [
            'roles' => [
                'guest' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                'Shop\Controller\Cart' => ['action' => 'all'],
                                'Shop\Controller\Catalog' => ['action' => 'all'],
                                'Shop\Controller\Checkout' => ['action' => ['index']],
                                'Shop\Controller\Product' => ['action' => [ 'view']],
                                'Shop\Controller\Shop' => ['action' => ['shop-front']],
                            ],
                        ],
                    ],
                ],
                'registered' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                'Shop\Controller\Checkout' => ['action' => 'all'],
                                'Shop\Controller\Country\Province' => ['action' => ['country-province-list']],
                                'Shop\Controller\Customer' => ['action' => ['my-details']],
                                'Shop\Controller\Customer\Address' => ['action' => ['my-addresses', 'edit-address', 'add-address', 'delete-address']],
                                'Shop\Controller\Order' => ['action' => ['cancel', 'my-orders', 'print', 'view']],
                                'Shop\Controller\Payment' => ['action' => 'all'],
                                'Shop\Controller\Paypal' => ['action' => ['process', 'success', 'cancel']],
                            ],
                        ],
                    ],
                ],
                'admin' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                'Shop\Controller\Advert' => ['action' => 'all'],
                                'Shop\Controller\Country' => ['action' => 'all'],
                                'Shop\Controller\Country\Province' => ['action' => 'all'],
                                'Shop\Controller\Customer' => ['action' => 'all'],
                                'Shop\Controller\Customer\Address' => ['action' => 'all'],
                                'Shop\Controller\Order' => ['action' => 'all'],
                                'Shop\Controller\Post\Cost' => ['action' => 'all'],
                                'Shop\Controller\Post\Level' => ['action' => 'all'],
                                'Shop\Controller\Post\Unit' => ['action' => 'all'],
                                'Shop\Controller\Post\Zone' => ['action' => 'all'],
                                'Shop\Controller\Product' => ['action' => 'all'],
                                'Shop\Controller\Product\Category' => ['action' => 'all'],
                                'Shop\Controller\Product\Image' => ['action' => 'all'],
                                'Shop\Controller\Product\Group' => ['action' => 'all'],
                                'Shop\Controller\Product\Option' => ['action' => 'all'],
                                'Shop\Controller\Product\Size' => ['action' => 'all'],
                                'Shop\Controller\Shop' => ['action' => 'all'],
                                'Shop\Controller\Tax\Code' => ['action' => 'all'],
                                'Shop\Controller\Tax\Rate' => ['action' => 'all'],
                                'Shop\Controller\Report' => ['action' => 'all'],
                                'Shop\Controller\Settings' => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                'Shop\Controller\Advert',
                'Shop\Controller\Cart',
                'Shop\Controller\Catalog',
                'Shop\Controller\Checkout',
                'Shop\Controller\Country',
                'Shop\Controller\Country\Province',
                'Shop\Controller\Customer',
                'Shop\Controller\Customer\Address',
                'Shop\Controller\Order',
                'Shop\Controller\Payment',
                'Shop\Controller\Paypal',
                'Shop\Controller\Post\Cost',
                'Shop\Controller\Post\Level',
                'Shop\Controller\Post\Unit',
                'Shop\Controller\Post\Zone',
                'Shop\Controller\Product',
                'Shop\Controller\Product\Category',
                'Shop\Controller\Product\Image',
                'Shop\Controller\Product\Group',
                'Shop\Controller\Product\Option',
                'Shop\Controller\Product\Size',
                'Shop\Controller\Shop',
                'Shop\Controller\Tax\Code',
                'Shop\Controller\Tax\Rate',
                'Shop\Controller\Report',
                'Shop\Controller\Settings',
            ],
        ],
    ],
];