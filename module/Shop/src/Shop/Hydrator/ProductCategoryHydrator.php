<?php

namespace Shop\Hydrator;

use Common\Hydrator\AbstractHydrator;
use Common\Hydrator\Strategy\DateTime as DateTimeStrategy;
use Common\Hydrator\Strategy\TrueFalse;

/**
 * Class Category
 *
 * @package Shop\Hydrator
 */
class ProductCategoryHydrator extends AbstractHydrator
{
	protected $addDepth = false;
	
	public function __construct()
	{
		parent::__construct();
		
		$dateTime = new DateTimeStrategy();
		$trueFalse = new TrueFalse();

		$this->addStrategy('enabled', $trueFalse);
		$this->addStrategy('discontinued', $trueFalse);
		$this->addStrategy('showImage', $trueFalse);
		$this->addStrategy('dateCreated', $dateTime);
		$this->addStrategy('dateModified', $dateTime);
	}
	
	public function addDepth()
	{
		$this->addDepth = true;
	}
	
	/**
	 * @param \Shop\Model\ProductCategoryModel $object
	 * @return array $data
	 */
	public function extract($object)
	{
		$data = [
			'productCategoryId'	=> $object->getProductCategoryId(),
			'ident'				=> $object->getIdent(),
			'category'			=> $object->getCategory(),
            'image'             => $object->getImage(),
			'lft'				=> $object->getLft(),
			'rgt'				=> $object->getRgt(),
			'enabled'			=> $this->extractValue('enabled', $object->isEnabled()),
			'discontinued'		=> $this->extractValue('discontinued', $object->isDiscontinued()),
		    'showImage'		    => $this->extractValue('showImage', $object->getShowImage()),
			'dateCreated'		=> $this->extractValue('dateCreated', $object->getDateCreated()),
			'dateModified'		=> $this->extractValue('dateModified', $object->getDateModified())
        ];
		
		if (true === $this->addDepth) {
			$data['depth'] = $object->getDepth();
		}
		
		return $data;
	}
}
