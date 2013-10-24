<?php

return array(
    'shared'        => array(
        'Shop\Form\Customer\Address'            => false,
    ),
	'invokables'    => array(
	    'Shop\InputFilter\Product' 			    => 'Shop\InputFilter\Product',
		'Shop\InputFilter\ProductCategory'	    => 'Shop\InputFilter\ProductCategory',
		'Shop\InputFilter\ProductImage'		    => 'Shop\InputFilter\ProductImage',
		'Shop\InputFilter\ProductOption'	    => 'Shop\InputFilter\ProductOption',
		'Shop\InputFilter\ProductPostUnit'	    => 'Shop\InputFilter\ProductPostUnit',
		'Shop\InputFilter\ProductSize'		    => 'Shop\InputFilter\ProductSize',
		'Shop\InputFilter\ProductStockStatus'   => 'Shop\InputFilter\ProductStockStatus',
		'Shop\InputFilter\TaxCode'				=> 'Shop\InputFilter\TaxCode',
		'Shop\InputFilter\TaxRate'				=> 'Shop\InputFilter\TaxRate',
	    
	    'Shop\Mapper\Country'                   => 'Shop\Mapper\Country',
	    'Shop\Mapper\CustomerAddress'           => 'Shop\Mapper\CustomerAddress',
	    'Shop\Mapper\CustomerBillingAddress'    => 'Shop\Mapper\CustomerBillingAddress',
	    'Shop\Mapper\CustomerDeliveryAddress'   => 'Shop\Mapper\CustomerDeliveryAddress',
	    'Shop\Mapper\Order'                     => 'Shop\Mapper\Order',
	    'Shop\Mapper\OrderLine'                 => 'Shop\Mapper\OrderLine',
	    'Shop\Mapper\OrderStatus'               => 'Shop\Mapper\OrderStatus',
	    'Shop\Mapper\PostCost'                  => 'Shop\Mapper\PostCost',
	    'Shop\Mapper\PostLevel'                 => 'Shop\Mapper\PostLevel',
	    'Shop\Mapper\PostZone'                  => 'Shop\Mapper\PostZone',
		'Shop\Mapper\Product' 				    => 'Shop\Mapper\Product',
		'Shop\Mapper\ProductCategory'		    => 'Shop\Mapper\ProductCategory',
		'Shop\Mapper\ProductImage'			    => 'Shop\Mapper\ProductImage',
		'Shop\Mapper\ProductOption'			    => 'Shop\Mapper\ProductOption',
		'Shop\Mapper\ProductPostUnit'		    => 'Shop\Mapper\ProductPostUnit',
		'Shop\Mapper\ProductSize'			    => 'Shop\Mapper\ProductSize',
		'Shop\Mapper\ProductStockStatus'	    => 'Shop\Mapper\ProductStockStatus',
		'Shop\Mapper\TaxCode'				    => 'Shop\Mapper\TaxCode',
		'Shop\Mapper\TaxRate'				    => 'Shop\Mapper\TaxRate',
		
		'Shop\Service\Product' 				    => 'Shop\Service\Product',
		'Shop\Service\ProductCategory'          => 'Shop\Service\ProductCategory',
		'Shop\Service\Shipping'                 => 'Shop\Service\Shipping',
		'Shop\Service\Taxation'                 => 'Shop\Service\Taxation',
	),
    'factories' => array(
        'Shop\Form\Customer\Address'            => 'Shop\Service\Factory\AddressFormFactory',
        
        'Shop\Service\Cart'                     => 'Shop\Service\Factory\CartFactory',
    ),
);