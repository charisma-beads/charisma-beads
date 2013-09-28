<?php
namespace Shop\Model;

use Shop\Model\AbstractModel;

class ProductOption extends AbstractModel
{
	/**
	 * @var int
	 */
	protected $productOptionId;
	
	/**
	 * @var int
	 */
	protected $productId;
	
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
