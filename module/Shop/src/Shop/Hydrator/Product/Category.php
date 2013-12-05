<?php
namespace Shop\Hydrator\Product;

use Application\Hydrator\AbstractHydrator;
use Application\Hydrator\Strategy\DateTime as DateTimeStrategy;
use Application\Hydrator\Strategy\TrueFalse;

class Category extends AbstractHydrator
{
	protected $addDepth = false;
	
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
		
		if (true === $this->addDepth) {
			$data['depth'] = $object->getDepth();
		}
		
		return $data;
	}
}
