<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;
use Application\Hydrator\Strategy\DateTime as DateTimeStrategy;
use Shop\Model\Product;

class Product extends AbstractHydrator
{
	public Function __construct()
	{
		parent::__construct();
		
		$this->addStrategy('dateCreated', new DateTimeStrategy());
		$this->addStrategy('dateModified', new DateTimeStrategy());
	}
	
	public function extract(Product $object)
	{
		return array(
			
		);
	}
}
