<?php

return array(
	'invokables' => array(
		'Shop\Mapper\Product' 				=> 'Shop\Mapper\Product',
		'Shop\Mapper\ProductCategory'		=> 'Shop\Mapper\ProductCategory',
		'Shop\Mapper\ProductImage'			=> 'Shop\Mapper\ProductImage',
		'Shop\Mapper\ProductOption'			=> 'Shop\Mapper\ProductOption',
		'Shop\Mapper\ProductPostUnit'		=> 'Shop\Mapper\ProductPostUnit',
		'Shop\Mapper\ProductSize'			=> 'Shop\Mapper\ProductSize',
		'Shop\Mapper\ProductStockStatus'	=> 'Shop\Mapper\ProductStockStatus',
		'Shop\Mapper\TaxCode'				=> 'Shop\Mapper\TaxCode',
		'Shop\Mapper\TaxRate'				=> 'Shop\Mapper\TaxRate',
		
		'Shop\Service\Cart'					=> 'Shop\Service\Cart',
		'Shop\Service\Catalog' 				=> 'Shop\Service\Catalog',
		'Shop\Service\Shipping'				=> 'Shop\Service\Shipping',
		'Shop\Service\Taxation'				=> 'Shop\Service\Taxation',
	),
);