<?php
namespace Shop\Hydrator\Product;

use UthandoCommon\Hydrator\AbstractHydrator;
use UthandoCommon\Hydrator\Strategy\DateTime as DateTimeStrategy;
use UthandoCommon\Hydrator\Strategy\Null as NullStrategy;
use UthandoCommon\Hydrator\Strategy\TrueFalse;

class Category extends AbstractHydrator
{
	protected $addDepth = false;
	
	public function __construct()
	{
		parent::__construct();
		
		$dateTime = new DateTimeStrategy();
		$trueFalse = new TrueFalse();
		
		$this->addStrategy('productImageId', new NullStrategy());
		$this->addStrategy('enabled', $trueFalse);
		$this->addStrategy('discontinued', $trueFalse);
		$this->addStrategy('dateCreated', $dateTime);
		$this->addStrategy('dateModified', $dateTime);
	}
	
	public function addDepth()
	{
		$this->addDepth = true;
	}
	
	/**
	 * @param \Shop\Model\Product\Category $object
	 * @return array $data
	 */
	public function extract($object)
	{
		$data = array(
			'productCategoryId'	=> $object->getProductCategoryId(),
			'productImageId'	=> $this->extractValue('productImageId', $object->getProductImageId()),
			'ident'				=> $object->getIdent(),
			'category'			=> $object->getCategory(),
			'lft'				=> $object->getLft(),
			'rgt'				=> $object->getRgt(),
			'enabled'			=> $this->extractValue('enabled', $object->getEnabled()),
			'discontinued'		=> $this->extractValue('discontinued', $object->getDiscontinued()),
			'dateCreated'		=> $this->extractValue('dateCreated', $object->getDateCreated()),
			'dateModified'		=> $this->extractValue('dateModified', $object->getDateModified())
		);
		
		if (true === $this->addDepth) {
			$data['depth'] = $object->getDepth();
		}
		
		return $data;
	}
}
