<?php

return array(
	'invokables' => array(
		'Shop\Model\Cart'		=> 'Shop\Model\Cart',
		'Shop\Model\Catalog' 	=> 'Shop\Model\Catalog',
		'Shop\Model\Product' 	=> 'Shop\Model\Product',
		'Shop\Model\Shipping'	=> 'Shop\Model\Shipping',
		'Shop\Model\Category'	=> 'Shop\Model\Product\Category',
	),
	'factories' => array(
		'Shop\Gateway\Category'	=> 'Shop\Service\DbTable\CategoryFactory',
		'Shop\Gateway\Product'	=> 'Shop\Service\DbTable\ProductFactory',
	)
);