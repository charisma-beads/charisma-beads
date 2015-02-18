<?php

return [
    'shared'        => [
        'ShopCatalogSearch'     => true,
    ],
    'invokables' => [
        'ShopCartAdd'           => 'Shop|InputFilter\Cart\Add',
        'ShopCatalogSearch'     => 'Shop\InputFilter\Catalog\Search',
        'ShopCountry'           => 'Shop\InputFilter\Country\Country',
        'ShopCountryProvince'   => 'Shop\InputFilter\Country\Province',
        'ShopCustomer'          => 'Shop\InputFilter\Customer\Customer',
        'ShopCustomerAddress'   => 'Shop\InputFilter\Customer\Address',
        'ShopOrder'             => 'Shop\InputFilter\Order\Order',
        'ShopOrderConfirm'      => 'Shop\InputFilter\Order\Confirm',
        'ShopOrderLine'         => 'Shop\InputFilter\Order\Line',
        'ShopOrderStatus'       => 'Shop\InputFilter\Order\Status',
        'ShopPaymentCreditCard' => 'Shop\InputFilter\Payment\CreditCard',
        'ShopPostCost'          => 'Shop\InputFilter\Post\Cost',
        'ShopPostLevel'         => 'Shop\InputFilter\Post\Level',
        'ShopPostUnit'          => 'Shop\InputFilter\Post\Unit',
        'ShopPostZone'          => 'Shop\InputFilter\Post\Zone',
        'ShopProduct'           => 'Shop\InputFilter\Product\Product',
        'ShopProductCategory'   => 'Shop\InputFilter\Product\Category',
        'ShopProductGroup'      => 'Shop\InputFilter\Product\Group',
        'ShopProductImage'      => 'Shop\InputFilter\Product\Image',
        'ShopProductOption'     => 'Shop\InputFilter\Product\Option',
        'ShopProductSize'       => 'Shop\InputFilter\Product\Size',
        'ShopTaxCode'           => 'Shop\InputFilter\Tax\Code',
        'ShopTaxRate'           => 'Shop\InputFilter\Tax\Rate',
    ],
];