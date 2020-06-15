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

use Common\Model\DateCreatedTrait;
use Common\Model\DateModifiedTrait;
use Common\Model\Model;
use Common\Model\ModelInterface;

/**
 * Class Image
 *
 * @package Shop\Model
 */
class ProductImageModel implements ModelInterface
{
    use Model,
        DateCreatedTrait,
        DateModifiedTrait;

	/**
	 * @var int
	 */
	protected $productImageId;
	
	/**
	 * @var int
	 */
	protected $productId;
	
	/**
	 * @var string
	 */
	protected $thumbnail;
	
	/**
	 * @var string
	 */
	protected $full;
	
	/**
	 * @var bool
	 */
	protected $isDefault = false;
	
	/**
	 * @var ProductModel
	 */
	protected $product;

    /**
     * @return int
     */
    public function getProductImageId()
	{
		return $this->productImageId;
	}

    /**
     * @param $productImageId
     * @return $this
     */
    public function setProductImageId($productImageId)
	{
		$this->productImageId = $productImageId;
		return $this;
	}

    /**
     * @return int
     */
    public function getProductId()
	{
		return $this->productId;
	}

    /**
     * @param $productId
     * @return $this
     */
    public function setProductId($productId)
	{
		$this->productId = $productId;
		return $this;
	}

    /**
     * @return string
     */
    public function getThumbnail()
	{
		return $this->thumbnail;
	}

    /**
     * @param $thumbnail
     * @return $this
     */
    public function setThumbnail($thumbnail)
	{
		$this->thumbnail = $thumbnail;
		return $this;
	}

    /**
     * @return string
     */
    public function getFull()
	{
		return $this->full;
	}

    /**
     * @param $full
     * @return $this
     */
    public function setFull($full)
	{
		$this->full = $full;
		return $this;
	}

    /**
     * @return bool
     */
    public function getIsDefault()
	{
		return $this->isDefault;
	}

    /**
     * @param $default
     * @return $this
     */
    public function setIsDefault($default)
	{
		$default = (bool) $default;
		$this->isDefault = $default;
		return $this;
	}

    /**
     * @return string
     */
    public function isDefaultImage()
	{
		return ($this->getIsDefault()) ? 'Yes' : 'No';
	}

    /**
     * @return ProductModel
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param ProductModel $product
     * @return $this
     */
    public function setProduct(ProductModel $product)
    {
        $this->product = $product;
        return $this;
    }
}
