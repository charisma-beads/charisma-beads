<?php

return [
    'invokables' => [
        'ShopCart'              => 'Shop\Service\Cart\Cart',
        'ShopCartItem'          => 'Shop\Service\Cart\Item',
        'ShopCountry'           => 'Shop\Service\Country\Country',
        'ShopCountryProvince'   => 'Shop\Service\Country\Province',
        'ShopCustomer'          => 'Shop\Service\Customer\Customer',
        'ShopCustomerAddress'   => 'Shop\Service\Customer\Address',
        'ShopCustomerPrefix'    => 'Shop\Service\Customer\Prefix',
        'ShopOrder'             => 'Shop\Service\Order\Order',
        'ShopOrderLine'         => 'Shop\Service\Order\Line',
        'ShopOrderStatus'       => 'Shop\Service\Order\Status',
        'ShopPostCost'          => 'Shop\Service\Post\Cost',
        'ShopPostLevel'         => 'Shop\Service\Post\Level',
        'ShopPostUnit'          => 'Shop\Service\Post\Unit',
        'ShopPostZone'          => 'Shop\Service\Post\Zone',
        'ShopProduct'           => 'Shop\Service\Product\Product',
        'ShopProductCategory'   => 'Shop\Service\Product\Category',
        'ShopProductGroup'      => 'Shop\Service\Product\Group',
        'ShopProductImage'      => 'Shop\Service\Product\Image',
        'ShopProductOption'     => 'Shop\Service\Product\Option',
        'ShopProductSize'       => 'Shop\Service\Product\Size',
        'ShopTaxCode'           => 'Shop\Service\Tax\Code',
        'ShopTaxRate'           => 'Shop\Service\Tax\Rate',
    ],
];