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

use UthandoCommon\Hydrator\AbstractHydrator;
use UthandoCommon\Hydrator\Strategy\DateTime as DateTimeStrategy;
use UthandoCommon\Hydrator\Strategy\TrueFalse;

/**
 * Class Category
 *
 * @package Shop\Hydrator\Product
 */
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
		$this->addStrategy('showImage', $trueFalse);
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
