<?php
namespace Shop\Model\Product;

use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;
use Shop\Model\Product;
use DateTime;

class Image implements ModelInterface
{
    use Model;
    
	/**
	 * @var int
	 */
	protected $productImageId;
	
	/**
	 * @var Product
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
	 * @var DateTime
	 */
	protected $dateCreated;
	
	/**
	 * @var DateTime
	 */
	protected $dateModified;
	
	/**
	 * @var Product
	 */
	protected $product;
	
	/**
	 * @return the $productImageId
	 */
	public function getProductImageId()
	{
		return $this->productImageId;
	}

	/**
	 * @param number $productImageId
	 */
	public function setProductImageId($productImageId)
	{
		$this->productImageId = $productImageId;
		return $this;
	}

	/**
	 * @return the $productId
	 */
	public function getProductId()
	{
		return $this->productId;
	}

	/**
	 * @param \Shop\Model\Product $productId
	 */
	public function setProductId($productId)
	{
		$this->productId = $productId;
		return $this;
	}

	/**
	 * @return the $thumbnail
	 */
	public function getThumbnail()
	{
		return $this->thumbnail;
	}

	/**
	 * @param string $thumbnail
	 */
	public function setThumbnail($thumbnail)
	{
		$this->thumbnail = $thumbnail;
		return $this;
	}

	/**
	 * @return the $full
	 */
	public function getFull()
	{
		return $this->full;
	}

	/**
	 * @param string $full
	 */
	public function setFull($full)
	{
		$this->full = $full;
		return $this;
	}

	/**
	 * @return the $default
	 */
	public function getIsDefault()
	{
		return $this->isDefault;
	}

	/**
	 * @param number $default
	 */
	public function setIsDefault($default)
	{
		$default = (bool) $default;
		$this->isDefault = $default;
		return $this;
	}

	/**
	 * @return the $dateCreated
	 */
	public function getDateCreated()
	{
		return $this->dateCreated;
	}

	/**
	 * @param DateTime $dateCreated
	 */
	public function setDateCreated(DateTime $dateCreated=null)
	{
		$this->dateCreated = $dateCreated;
		return $this;
	}

	/**
	 * @return the $dateModified
	 */
	public function getDateModified()
	{
		return $this->dateModified;
	}

	/**
	 * @param DateTime $dateModified
	 */
	public function setDateModified(DateTime $dateModified=null)
	{
		$this->dateModified = $dateModified;
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
	 * @return \Shop\Model\Product
	 */
	public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return \Shop\Model\Product\Image
     */
	public function setProduct(Product $product)
    {
        $this->product = $product;
        return $this;
    }

}
