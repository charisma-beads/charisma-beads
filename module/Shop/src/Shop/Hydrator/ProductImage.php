<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;
use Application\Hydrator\Strategy\DateTime as DateTimeStrategy;
use Application\Hydrator\Strategy\TrueFalse;

class ProductImage extends AbstractHydrator
{
	public function __construct()
	{
		parent::__construct();
		
		$dateTime = new DateTimeStrategy();
		
		$this->addStrategy('default', new TrueFalse());
		$this->addStrategy('dateCreated', $dateTime);
		$this->addStrategy('dateModified', $dateTime);
	}
	
	/**
	 * @param \Shop\Model\ProductImage $object
	 * @return array $data
	 */
	public Function extract($object)
	{
		return array(
			'productImageId'	=> $object->getProductImageId(),
			'productId'			=> $object->getProductId(),
			'thumbnail'			=> $object->getThumbnail(),
			'full'				=> $object->getFull(),
			'default'			=> $this->extractValue('default', $object->getDefault()),
			'dateCreated'		=> $this->extractValue('dateCreated', $object->getDateCreated()),
			'dateModified'		=> $this->extractValue('dateCreated', $object->getDateModified())
		);
	}
}
