<?php
namespace Shop\Model\Product;

use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

class Option implements ModelInterface
{
    use Model;
    
	/**
	 * @var int
	 */
	protected $productOptionId;
	
	/**
	 * @var int
	 */
	protected $productId;
	
	/**
	 * @var int $postUnitId
	 */
	protected $postUnitId;
	
	/**
	 * @var string
	 */
	protected $option;
	
	/**
	 * @var float
	 */
	protected $price;
	
	/**
	 * @return the $productOptionId
	 */
	public function getProductOptionId()
	{
		return $this->productOptionId;
	}

	/**
	 * @param number $productOptionId
	 */
	public function setProductOptionId($productOptionId)
	{
		$this->productOptionId = $productOptionId;
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
	 * @param number $productId
	 */
	public function setProductId($productId)
	{
		$this->productId = $productId;
		return $this;
	}

	/**
	 * @return the $postUnitId
	 */
	public function getPostUnitId()
	{
		return $this->postUnitId;
	}

	/**
	 * @param number $postUnitId
	 */
	public function setPostUnitId($postUnitId)
	{
		$this->postUnitId = $postUnitId;
	}

	/**
	 * @return the $option
	 */
	public function getOption()
	{
		return $this->option;
	}

	/**
	 * @param string $option
	 */
	public function setOption($option)
	{
		$this->option = $option;
		return $this;
	}

	/**
	 * @return the $price
	 */
	public function getPrice()
	{
		return $this->price;
	}

	/**
	 * @param number $price
	 */
	public function setPrice($price)
	{
		$this->price = $price;
		return $this;
	}
}
