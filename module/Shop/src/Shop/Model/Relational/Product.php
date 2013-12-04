<?php
namespace Shop\Model\Relational;

use Shop\Model\Product as Base;

class Product extends Base
{
    /**
     * @var string
     */
    protected $category;
    
    /**
     * @var string
     */
    protected $group;
    
    /**
     * @var array
     */
    protected $images;
    
    /**
     * @var int
     */
    protected $postUnit;
    
    /**
     * @var string
     */
    protected $size;
    
    /**
     * @var string
     */
    protected $stockStatus;
    
    /**
     * @var string
     */
    protected $taxCode;
    
    /**
     * @var float
     */
    protected $taxRate;
    
	/**
	 * @return string $category
	 */
	public function getCategory()
	{
		return $this->category;
	}

	/**
	 * @param string $category
	 */
	public function setCategory($category)
	{
		$this->category = $category;
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
	 * @return multitype: $images
	 */
	public function getImages()
	{
		return $this->images;
	}

	/**
	 * @param multitype: $images
	 */
	public function setImages($images)
	{
		$this->images = $images;
		return $this;
	}

	/**
	 * @return number $postUnit
	 */
	public function getPostUnit()
	{
		return $this->postUnit;
	}

	/**
	 * @param number $postUnit
	 */
	public function setPostUnit($postUnit)
	{
		$this->postUnit = $postUnit;
		return $this;
	}

	/**
	 * @return string $size
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

	/**
	 * @return string $stockStatus
	 */
	public function getStockStatus()
	{
		return $this->stockStatus;
	}

	/**
	 * @param string $stockStatus
	 */
	public function setStockStatus($stockStatus)
	{
		$this->stockStatus = $stockStatus;
		return $this;
	}

	/**
	 * @return string $taxCode
	 */
	public function getTaxCode()
	{
		return $this->taxCode;
	}

	/**
	 * @param string $taxCode
	 */
	public function setTaxCode($taxCode)
	{
		$this->taxCode = $taxCode;
		return $this;
	}

	/**
	 * @return number $taxRate
	 */
	public function getTaxRate()
	{
		return $this->taxRate;
	}

	/**
	 * @param number $taxRate
	 */
	public function setTaxRate($taxRate)
	{
		$this->taxRate = $taxRate;
		return $this;
	}

}
