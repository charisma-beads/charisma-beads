<?php
namespace Shop\Model;

use Shop\Model\AbstractModel;
use Shop\Model\Product;
use DateTime;

class ProductImage extends AbstractModel
{
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
	 * @var int
	 */
	protected $default;
	
	/**
	 * @var DateTime
	 */
	protected $dateCreated;
	
	/**
	 * @var DateTime
	 */
	protected $dateModified;
	
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
	}

	/**
	 * @return the $default
	 */
	public function getDefault()
	{
		return $this->default;
	}

	/**
	 * @param number $default
	 */
	public function setDefault($default)
	{
		$this->default = $default;
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
	}
}
