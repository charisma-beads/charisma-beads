<?php
namespace Shop\Model\Product;

use Application\Model\Model;
use Application\Model\RelationalModel;
use Application\Model\ModelInterface;

class Size implements ModelInterface
{
    use Model, RelationalModel;
    
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
