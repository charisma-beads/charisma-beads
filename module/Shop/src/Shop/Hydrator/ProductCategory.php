<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;
use Application\Hydrator\Strategy\DateTime as DateTimeStrategy;
use Application\Hydrator\Strategy\TrueFalse;
use Shop\Model\ProductCategory;

class ProductCategory extends AbstractHydrator
{
	public function __construct()
	{
		parent::__construct();
		
		$dateTime = new DateTimeStrategy();
		$trueFalse = new TrueFalse();
		
		$this->addStrategy('enabled', $trueFalse);
		$this->addStrategy('discontinued', $trueFalse);
		$this->addStrategy('dateCreated', $dateTime);
		$this->addStrategy('dateModified', $dateTime);
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
			'enabled'			=> $this->extractValue('enabled', $object->getEnabled()),
			'discontinued'		=> $this->extractValue('discontinued', $object->getDiscontinued()),
			'dateCreated'		=> $this->extractValue('dateCreated', $object->getDateCreated()),
			'dateModified'		=> $this->extractValue('dateModified', $object->getDateModified())
		);
	}
}
