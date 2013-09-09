<?php
namespace Shop\Model;

use Application\Model\DbTable\AbstractTable;

class Catalog extends AbstractTable
{
	protected $classMap = array(
		'gateways'	=> array(
			'product'	=> 'Shop\Model\DbTable\Product',
			'category'	=> 'Shop\Model\DbTable\Product\Category',
		),
		'entities'	=> array(
			'product'	=> 'Shop\Model\Entity\Product',
			'category'	=> 'Shop\Model\Entity\Product\Category',
		),
		'forms'		=> array(
			
		),
	);
}
