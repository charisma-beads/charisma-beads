<?php
namespace Shop\Model\Product;

use Application\Model\AbstractModel;

class Size extends AbstractModel
{
	/**
	 * @var int
	 */
	protected $productSizeId;
	
	/**
	 * @var string
	 */
	protected $size;
	
	/**
	 * @return the $productSizeId
	 */
	public function getProductSizeId()
	{
		return $this->productSizeId;
	}

	/**
	 * @param number $productSizeId
	 */
	public function setProductSizeId($productSizeId)
	{
		$this->productSizeId = $productSizeId;
		return $this;
	}

	/**
	 * @return the $size
	 */
	public function getSize()
	{
		return $this->size;
	}

	/**
	 * @param string $size
	 */
	public function setSize($size)
	{
		$this->size = $size;
		return $this;
	}
}
