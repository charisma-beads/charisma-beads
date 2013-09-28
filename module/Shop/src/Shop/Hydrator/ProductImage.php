<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;
use Application\Hydrator\Strategy\DateTime as DateTimeStrategy;
use Shop\Model\ProductImage;

class ProductImage extends AbstractHydrator
{
	public function __construct()
	{
		parent::__construct();
		
		$this->addStrategy('dateCreated', new DateTimeStrategy());
		$this->addStrategy('dateModified', new DateTimeStrategy());
	}
	
	public Function extract(ProductImage $object)
	{
		return array(
			'productImageId'	=> $object->getProductImageId(),
			'productId'			=> $object->getProductId(),
			'thumbnail'			=> $object->getThumbnail(),
			'full'				=> $object->getFull(),
			'default'			=> $object->getDefault(),
			'dateCreated'		=> $this->extractValue('dateCreated', $object->getDateCreated()),
			'dateModified'		=> $this->extractValue('dateCreated', $object->getDateModified())
		);
	}
}
