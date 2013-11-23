<?php

return array(
	'invokables' => array(
		'Shop\Controller\Cart'		=> 'Shop\Controller\CartController',
		'Shop\Controller\Catalog'	=> 'Shop\Controller\CatalogController',
		'Shop\Controller\Checkout'  => 'Shop\Controller\CheckoutController',
        'Shop\Controller\Payment'   => 'Shop\Controller\PaymentController',
        'Shop\Controller\Paypal'    => 'Shop\Controller\PaypalController',     
		'Shop\Controller\Product'	=> 'Shop\Controller\ProductController',
		'Shop\Controller\Shop'		=> 'Shop\Controller\ShopController',
	),
);