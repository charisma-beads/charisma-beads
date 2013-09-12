<?php
namespace Shop\Model\Product;

use Application\Model\AbstractModel;

class Category extends AbstractModel
{
	protected $classMap = array(
		'gateways'	=> array(
			'category'	=> 'Shop\Model\DbTable\Product\Category',
		),
		'entities'	=> array(
			'category'	=> 'Shop\Model\Entity\Product\Category',
		),
		'forms'		=> array(
					
		),
	);
	
	public function getTopLevelCategories()
	{
		return $this->getGateway('category')->getFullTree(true);
	}
}
