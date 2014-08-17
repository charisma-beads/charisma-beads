<?php
return [
    'invokables' => [
        'Shop\Controller\Cart'                  => 'Shop\Controller\Cart',
        'Shop\Controller\Catalog'               => 'Shop\Controller\Catalog',
        'Shop\Controller\Checkout'              => 'Shop\Controller\Checkout',
        'Shop\Controller\Country'               => 'Shop\Controller\Country\Country',
        'Shop\Controller\Country\Province'      => 'Shop\Controller\Country\CountryProvince',
        'Shop\Controller\Customer'              => 'Shop\Controller\Customer\Customer',
        'Shop\Controller\Customer\Address'      => 'Shop\Controller\Customer\CustomerAddress',
        'Shop\Controller\Order'                 => 'Shop\Controller\Order\Order',
        'Shop\Controller\Payment'               => 'Shop\Controller\Payment',
        'Shop\Controller\Paypal'                => 'Shop\Controller\Paypal',
        'Shop\Controller\Post\Cost'             => 'Shop\Controller\Post\PostCost',
        'Shop\Controller\Post\Level'            => 'Shop\Controller\Post\PostLevel',
        'Shop\Controller\Post\Unit'             => 'Shop\Controller\Post\PostUnit',
        'Shop\Controller\Post\Zone'             => 'Shop\Controller\Post\PostZone',
        'Shop\Controller\Product'               => 'Shop\Controller\Product\Product',
        'Shop\Controller\Product\Category'      => 'Shop\Controller\Product\ProductCategory',
        'Shop\Controller\Product\Image'         => 'Shop\Controller\Product\ProductImage',
        'Shop\Controller\Product\GroupPrice'    => 'Shop\Controller\Product\ProductGroupPrice',
        'Shop\Controller\Shop'                  => 'Shop\Controller\Shop',
        'Shop\Controller\Tax\Code'              => 'Shop\Controller\Tax\TaxCode',
        'Shop\Controller\Tax\Rate'              => 'Shop\Controller\Tax\TaxRate'
    ],
];