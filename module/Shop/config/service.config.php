<?php

return [
    'invokables' => [
        'Shop\Service\Cart\Item'                => 'Shop\Service\Cart\Item',
        'Shop\Service\Country'                  => 'Shop\Service\Country\Country',
        'Shop\Service\Country\Province'         => 'Shop\Service\Country\Province',
        'Shop\Service\Customer'                 => 'Shop\Service\Customer\Customer',
        'Shop\Service\Customer\Address'         => 'Shop\Service\Customer\Address',
        'Shop\Service\Customer\Prefix'          => 'Shop\Service\Customer\Prefix',
        'Shop\Service\Order'                    => 'Shop\Service\Order\Order',
        'Shop\Service\Order\Line'               => 'Shop\Service\Order\Line',
        'Shop\Service\Order\Status'             => 'Shop\Service\Order\Status',
        'Shop\Service\Paypal'                   => 'Shop\Service\Paypal',
        'Shop\Service\Post\Cost'                => 'Shop\Service\Post\Cost',
        'Shop\Service\Post\Level'               => 'Shop\Service\Post\Level',
        'Shop\Service\Post\Unit'                => 'Shop\Service\Post\Unit',
        'Shop\Service\Post\Zone'                => 'Shop\Service\Post\Zone',
        'Shop\Service\Product'                  => 'Shop\Service\Product\Product',
        'Shop\Service\Product\Category'         => 'Shop\Service\Product\Category',
        'Shop\Service\Product\Group'            => 'Shop\Service\Product\Group',
        'Shop\Service\Product\Image'            => 'Shop\Service\Product\Image',
        'Shop\Service\Product\Option'           => 'Shop\Service\Product\Option',
        'Shop\Service\Product\Size'             => 'Shop\Service\Product\Size',
        'Shop\Service\StockControl'             => 'Shop\Service\StockControl',
        'Shop\Service\Tax'                      => 'Shop\Service\Tax\Tax',
        'Shop\Service\Tax\Code'                 => 'Shop\Service\Tax\Code',
        'Shop\Service\Tax\Rate'                 => 'Shop\Service\Tax\Rate',
    ],
    'factories' => [
        'Shop\Options\CartCookie'               => 'Shop\Service\Factory\CartCookieOptions',
        'Shop\Options\Checkout'                 => 'Shop\Service\Factory\CheckoutOptions',
        'Shop\Options\Paypal'                   => 'Shop\Service\Factory\PaypalOptions',
        'Shop\Options\Shop'                     => 'Shop\Service\Factory\ShopOptions',
        
        'Shop\Service\Cart\Cookie'              => 'Shop\Service\Factory\CartCookie',
        'Shop\Service\Shipping'                 => 'Shop\Service\Factory\Shipping'
    ],
];