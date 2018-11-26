<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Model\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Model;

use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

/**
 * Class Size
 *
 * @package Shop\Model
 */
class ProductSizeModel implements ModelInterface
{
    use Model;
    
	/**
	 * @var int
	 */
	protected $productSizeId;
	
	/**
	 * @var string
	 */
	protected $size;
	
	/**
	 * @return int $productSizeId
	 */
	public function getProductSizeId()
	{
		return $this->productSizeId;
	}

    /**
     * @param $productSizeId
     * @return $this
     */
	public function setProductSizeId($productSizeId)
	{
		$this->productSizeId = $productSizeId;
		return $this;
	}

    /**
     * @return string
     */
	public function getSize()
	{
		return $this->size;
	}

    /**
     * @param $size
     * @return $this
     */
	public function setSize($size)
	{
		$this->size = $size;
		return $this;
	}
}
