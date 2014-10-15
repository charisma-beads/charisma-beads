<?php
namespace Shop\Model\Product;

use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

class Size implements ModelInterface
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
	 * @return the $productSizeId
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
	 * @return the $size
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
