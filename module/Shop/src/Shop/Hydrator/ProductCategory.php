<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;
use Application\Hydrator\Strategy\DateTime as DateTimeStrategy;
use Shop\Model\ProductCategory;

class ProductCategory extends AbstractHydrator
{
	public function __construct()
	{
		parent::__construct();
		
		$this->addStrategy('dateCreated', new DateTimeStrategy())
			->addStrategy('dateModified', new DateTimeStrategy());
	}
	
	public function extract(ProductCategory $object)
	{
		return array(
			'productCategoryId'	=> $object->getProductCategoryId(),
			'productImageId'	=> $object->getProductImageId(),
			'ident'				=> $object->getIdent(),
			'category'			=> $object->getCategory(),
			'lft'				=> $object->getLft(),
			'rgt'				=> $object->getRgt(),
			'enabled'			=> $object->getEnabled(),
			'discontinued'		=> $object->getDiscontinued(),
			'dateCreated'		=> $this->extractValue('dateCreated', $object->getDateCreated()),
			'dateModified'		=> $this->extractValue('dateModified', $object->getDateModified())
		);
	}
}
