<?php

return array(
    'shared'        => array(
        'Shop\Form\Customer\Address'            => false,
    ),
	'invokables'    => array(
	    'Shop\InputFilter\PostUnit'	            => 'Shop\InputFilter\Post\Unit',
	    'Shop\InputFilter\Product' 			    => 'Shop\InputFilter\Product',
		'Shop\InputFilter\ProductCategory'	    => 'Shop\InputFilter\Product\Category',
		'Shop\InputFilter\ProductImage'		    => 'Shop\InputFilter\Product\Image',
		'Shop\InputFilter\ProductOption'	    => 'Shop\InputFilter\Product\Option',
		'Shop\InputFilter\ProductSize'		    => 'Shop\InputFilter\Product\Size',
		'Shop\InputFilter\StockStatus'          => 'Shop\InputFilter\Stock\Status',
		'Shop\InputFilter\TaxCode'				=> 'Shop\InputFilter\Tax\Code',
		'Shop\InputFilter\TaxRate'				=> 'Shop\InputFilter\Tax\Rate',
	    
	    'Shop\Mapper\Country'                   => 'Shop\Mapper\Country',
	    'Shop\Mapper\CustomerAddress'           => 'Shop\Mapper\Customer\Address',
	    'Shop\Mapper\CustomerBillingAddress'    => 'Shop\Mapper\Customer\BillingAddress',
	    'Shop\Mapper\CustomerDeliveryAddress'   => 'Shop\Mapper\Customer\DeliveryAddress',
	    'Shop\Mapper\Order'                     => 'Shop\Mapper\Order',
	    'Shop\Mapper\OrderLine'                 => 'Shop\Mapper\Order\Line',
	    'Shop\Mapper\OrderStatus'               => 'Shop\Mapper\Order\Status',
	    'Shop\Mapper\PostCost'                  => 'Shop\Mapper\Post\Cost',
	    'Shop\Mapper\PostLevel'                 => 'Shop\Mapper\Post\Level',
	    'Shop\Mapper\PostUnit'		            => 'Shop\Mapper\Post\Unit',
	    'Shop\Mapper\PostZone'                  => 'Shop\Mapper\Post\Zone',
		'Shop\Mapper\Product' 				    => 'Shop\Mapper\Product',
		'Shop\Mapper\ProductCategory'		    => 'Shop\Mapper\Product\Category',
		'Shop\Mapper\ProductImage'			    => 'Shop\Mapper\Product\Image',
		'Shop\Mapper\ProductOption'			    => 'Shop\Mapper\Product\Option',
		'Shop\Mapper\ProductSize'			    => 'Shop\Mapper\Product\Size',
		'Shop\Mapper\StockStatus'               => 'Shop\Mapper\Product\Stock\Status',
		'Shop\Mapper\TaxCode'				    => 'Shop\Mapper\Tax\Code',
		'Shop\Mapper\TaxRate'				    => 'Shop\Mapper\Tax\Rate',
		
	    'Shop\Service\Country'                  => 'Shop\Service\Country',
	    'Shop\Service\CustomerAddress'          => 'Shop\Service\Customer\Address',
		'Shop\Service\Product' 				    => 'Shop\Service\Product',
		'Shop\Service\ProductCategory'          => 'Shop\Service\Product\Category',
	    'Shop\Service\ProductImage'             => 'Shop\Service\Product\Image',
	    'Shop\Service\Tax'                      => 'Shop\Service\Tax',
	    'Shop\Service\TaxRate'                  => 'Shop\Service\Tax\Rate',
	),
    'factories' => array(
        'Shop\Form\Customer\Address'            => 'Shop\Service\Factory\AddressFormFactory',
        
        'Shop\Options\Checkout'                 => 'Shop\Service\Factory\CheckoutOptionsFactory',
        'Shop\Options\Paypal'                   => 'Shop\Service\Factory\PaypalOptionsFactory',
        'Shop\Options\Shop'                     => 'Shop\Service\Factory\ShopOptionsFactory',
        
        'Shop\Service\Cart'                     => 'Shop\Service\Factory\CartFactory',
        'Shop\Service\Shipping'                 => 'Shop\Service\Factory\ShippingFactory',
    ),
);