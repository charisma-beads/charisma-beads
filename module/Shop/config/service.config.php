<?php

return [
    'invokables' => [
        'Shop\Service\StockControl'             => 'Shop\Service\StockControl',
    ],
    'factories' => [
        'Shop\Options\CartCookie'               => 'Shop\Service\Factory\CartCookieOptions',
        'Shop\Options\Checkout'                 => 'Shop\Service\Factory\CheckoutOptions',
        'Shop\Options\Paypal'                   => 'Shop\Service\Factory\PaypalOptions',
        'Shop\Options\Shop'                     => 'Shop\Service\Factory\ShopOptions',
        
        'Shop\Service\Cart\Cookie'              => 'Shop\Service\Factory\CartCookie',
        'Shop\Service\Shipping'                 => 'Shop\Service\Factory\Shipping',
        'Shop\Service\Tax'                      => 'Shop\Service\Factory\Tax',
    ],
];