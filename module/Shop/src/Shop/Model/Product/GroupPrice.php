<?php

namespace Shop\Model\Product;

use Application\Model\Model;
use Application\Model\ModelInterface;

class GroupPrice implements ModelInterface
{
    use Model;
    
    /**
     * @var int
     */
    protected $productGroupId;
    
    /**
     * @var string
     */
    protected $group;
    
    /**
     * @var float
     */
    protected $price;
    
	/**
	 * @return number $groupId
	 */
	public function getProductGroupId()
	{
		return $this->productGroupId;
	}

	/**
	 * @param number $groupId
	 */
	public function setProductGroupId($productGroupId)
	{
		$this->productGroupId = $productGroupId;
		return $this;
	}

	/**
	 * @return string $group
	 */
	public function getGroup()
	{
		return $this->group;
	}

	/**
	 * @param string $group
	 */
	public function setGroup($group)
	{
		$this->group = $group;
		return $this;
	}

	/**
	 * @return number $price
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
