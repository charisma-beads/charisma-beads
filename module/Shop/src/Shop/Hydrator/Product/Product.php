<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Hydrator\Product;

use Shop\Hydrator\Strategy\NumberFormat;
use Shop\Hydrator\Strategy\Percent;
use UthandoCommon\Hydrator\AbstractHydrator;
use UthandoCommon\Hydrator\Strategy\DateTime as DateTimeStrategy;
use UthandoCommon\Hydrator\Strategy\TrueFalse;
use UthandoCommon\Hydrator\Strategy\NullStrategy;

/**
 * Class Product
 *
 * @package Shop\Hydrator\Product
 */
class Product extends AbstractHydrator
{   
	public Function __construct()
	{
		parent::__construct();
		
		$dateTime = new DateTimeStrategy();
		$trueFalse = new TrueFalse();
		
		$this->addStrategy('productGroupId', new NullStrategy());
        $this->addStrategy('price', new NumberFormat());
		$this->addStrategy('taxable', $trueFalse);
		$this->addStrategy('discountPercent', new Percent());
		$this->addStrategy('addPostage', $trueFalse);
		$this->addStrategy('enabled', $trueFalse);
		$this->addStrategy('discontinued', $trueFalse);
		$this->addStrategy('showImage', $trueFalse);
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
		return [
			'productId'				=> $object->getProductId(),
			'productCategoryId'		=> $object->getProductCategoryId(),
			'productSizeId'			=> $object->getProductSizeId(),
			'taxCodeId'				=> $object->getTaxCodeId(),
			'postUnitId'			=> $object->getPostUnitId(),
			'productGroupId'		=> $this->extractValue('productGroupId', $object->getProductGroupId()),
		    'sku'                   => $object->getSku(),
			'ident'					=> $object->getIdent(),
			'name'					=> $object->getName(),
			'price'					=> $this->extractValue('price', $object->getPrice(false)),
			'description'			=> $object->getDescription(),
			'shortDescription'		=> $object->getShortDescription(),
			'quantity'				=> $object->getQuantity(),
			'taxable'				=> $this->extractValue('taxable', $object->getTaxable()),
			'addPostage'			=> $this->extractValue('addPostage', $object->getAddPostage()),
			'discountPercent'		=> $this->extractValue('discountPercent', $object->getDiscountPercent()),
			'hits'					=> $object->getHits(),
			'enabled'				=> $this->extractValue('enabled', $object->isEnabled()),
			'discontinued'			=> $this->extractValue('discontinued', $object->isDiscontinued()),
		    'vatInc'                => $this->extractValue('vatInc', $object->getVatInc()),
		    'showImage'             => $this->extractValue('showImage', $object->getShowImage()),
			'dateCreated'			=> $this->extractValue('dateCreated', $object->getDateCreated()),
			'dateModified'			=> $this->extractValue('dateModified', $object->getDateModified())
		];
	}
}
