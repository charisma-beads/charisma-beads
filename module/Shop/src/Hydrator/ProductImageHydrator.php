<?php

namespace Shop\Hydrator;

use Common\Hydrator\AbstractHydrator;
use Common\Hydrator\Strategy\DateTime as DateTimeStrategy;
use Common\Hydrator\Strategy\TrueFalse;

/**
 * Class Image
 *
 * @package Shop\Hydrator
 */
class ProductImageHydrator extends AbstractHydrator
{
	public function __construct()
	{
		parent::__construct();
		
		$dateTime = new DateTimeStrategy();
		
		$this->addStrategy('isDefault', new TrueFalse());
		$this->addStrategy('dateCreated', $dateTime);
		$this->addStrategy('dateModified', $dateTime);
	}
	
	/**
	 * @param \Shop\Model\ProductImageModel $object
	 * @return array $data
	 */
	public Function extract($object)
	{
		return [
			'productImageId'	=> $object->getProductImageId(),
			'productId'			=> $object->getProductId(),
			'thumbnail'			=> $object->getThumbnail(),
			'full'				=> $object->getFull(),
			'isDefault'			=> $this->extractValue('isDefault', $object->getIsDefault()),
			'dateCreated'		=> $this->extractValue('dateCreated', $object->getDateCreated()),
			'dateModified'		=> $this->extractValue('dateCreated', $object->getDateModified())
        ];
	}
}
