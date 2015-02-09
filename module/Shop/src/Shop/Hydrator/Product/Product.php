<?php
namespace Shop\Hydrator\Product;

use UthandoCommon\Hydrator\AbstractHydrator;
use UthandoCommon\Hydrator\Strategy\DateTime as DateTimeStrategy;
use UthandoCommon\Hydrator\Strategy\TrueFalse;
use UthandoCommon\Hydrator\Strategy\Null as NullStrategy;
use Shop\Hydrator\Strategy\Percent;

class Product extends AbstractHydrator
{   
	public Function __construct()
	{
		parent::__construct();
		
		$dateTime = new DateTimeStrategy();
		$trueFalse = new TrueFalse();
		
		$this->addStrategy('productGroupId', new NullStrategy());
		$this->addStrategy('taxable', $trueFalse);
		$this->addStrategy('discountPercent', new Percent());
		$this->addStrategy('addPostage', $trueFalse);
		$this->addStrategy('enabled', $trueFalse);
		$this->addStrategy('discontinued', $trueFalse);
		$this->addStrategy('vatInc', $trueFalse);
		$this->addStrategy('dateCreated',$dateTime);
		$this->addStrategy('dateModified', $dateTime);
	}
	
	/**
	 * @param \Shop\Model\Product\Product $object
	 * @return array $data
	 */
	public function extract($object)
	{
		return array(
			'productId'				=> $object->getProductId(),
			'productCategoryId'		=> $object->getProductCategoryId(),
			'productSizeId'			=> $object->getProductSizeId(),
			'taxCodeId'				=> $object->getTaxCodeId(),
			'postUnitId'			=> $object->getPostUnitId(),
			'productGroupId'		=> $this->extractValue('productGroupId', $object->getProductGroupId()),
		    'sku'                   => $object->getSku(),
			'ident'					=> $object->getIdent(),
			'name'					=> $object->getName(),
			'price'					=> $object->getPrice(false),
			'description'			=> $object->getDescription(),
			'shortDescription'		=> $object->getShortDescription(),
			'quantity'				=> $object->getQuantity(),
			'taxable'				=> $this->extractValue('taxable', $object->getTaxable()),
			'addPostage'			=> $this->extractValue('addPostage', $object->getAddPostage()),
			'discountPercent'		=> $this->extractValue('discountPercent', $object->getDiscountPercent()),
			'hits'					=> $object->getHits(),
			'enabled'				=> $this->extractValue('enabled', $object->getEnabled()),
			'discontinued'			=> $this->extractValue('discontinued', $object->getDiscontinued()),
		    'vatInc'                => $this->extractValue('vatInc', $object->getVatInc()),
			'dateCreated'			=> $this->extractValue('dateCreated', $object->getDateCreated()),
			'dateModified'			=> $this->extractValue('dateModified', $object->getDateModified())
		);
	}
}
