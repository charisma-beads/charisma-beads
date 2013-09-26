<?php

return array(
	'invokables' => array(
		'Shop\Model\Cart'		=> 'Shop\Model\Cart',
		'Shop\Model\Catalog' 	=> 'Shop\Model\Catalog',
		'Shop\Model\Shipping'	=> 'Shop\Model\Shipping',
		'Shop\Model\Product' 	=> 'Shop\Model\Mapper\Product',
		'Shop\Model\Category'	=> 'Shop\Model\Mapper\Product\Category',
	),
	'factories' => array(
		'Shop\Gateway\Category'	=> 'Shop\Service\DbTable\CategoryFactory',
		'Shop\Gateway\Product'	=> 'Shop\Service\DbTable\ProductFactory',
	)
);