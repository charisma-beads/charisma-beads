<?php

return [
    'invokables' => [
        'ShopCart'              => 'Shop\Mapper\Cart\Cart',
        'ShopCartItem'          => 'Shop\Mapper\Cart\Item',
        'ShopCountry'           => 'Shop\Mapper\Country\Country',
        'ShopCountryProvince'   => 'Shop\Mapper\Country\Province',
        'ShopCustomer'          => 'Shop\Mapper\Customer\Customer',
        'ShopCustomerAddress'   => 'Shop\Mapper\Customer\Address',
        'ShopCustomerPrefix'    => 'Shop\Mapper\Customer\Prefix',
        'ShopOrder'             => 'Shop\Mapper\Order\Order',
        'ShopOrderLine'         => 'Shop\Mapper\Order\Line',
        'ShopOrderStatus'       => 'Shop\Mapper\Order\Status',
        'ShopPostCost'          => 'Shop\Mapper\Post\Cost',
        'ShopPostLevel'         => 'Shop\Mapper\Post\Level',
        'ShopPostUnit'          => 'Shop\Mapper\Post\Unit',
        'ShopPostZone'          => 'Shop\Mapper\Post\Zone',
        'ShopProduct'           => 'Shop\Mapper\Product\Product',
        'ShopProductCategory'   => 'Shop\Mapper\Product\Category',
        'ShopProductGroup'      => 'Shop\Mapper\Product\Group',
        'ShopProductImage'      => 'Shop\Mapper\Product\Image',
        'ShopProductOption'     => 'Shop\Mapper\Product\Option',
        'Shop\ProductSize'      => 'Shop\Mapper\Product\Size',
        'ShopTaxCode'           => 'Shop\Mapper\Tax\Code',
        'ShopTaxRate'           => 'Shop\Mapper\Tax\Rate',
    ],
];