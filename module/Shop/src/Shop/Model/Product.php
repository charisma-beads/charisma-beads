<?php
namespace Shop\Model;

use Application\Model\AbstractModel;
use DateTime;

class Product extends AbstractModel
{
	/**
	 * @var int
	 */
	protected $productId;
	
	/**
	 * @var int
	 */
	protected $productCategoryId;
	
	/**
	 * @var int
	 */
	protected $productSizeId;
	
	/**
	 * @var int
	 */
	protected $taxCodeId;
	
	/**
	 * @var int
	 */
	protected $productPostUnitId;
	
	/**
	 * @var int
	 */
	protected $productGroupId;
	
	/**
	 * @var int
	 */
	protected $productStockStatusId;
	
	/**
	 * @var string
	 */
	protected $ident;
	
	/**
	 * @var string
	 */
	protected $name;
	
	/**
	 * @var float
	 */
	protected $price;
	
	/**
	 * @var string
	 */
	protected $description;
	
	/**
	 * @var string
	 */
	protected $shortDescription;
	
	/**
	 * @var int
	 */
	protected $quantity;
	
	/**
	 * @var bool
	 */
	protected $taxable = false;
	
	/**
	 * @var bool
	 */
	protected $addPostage = true;
	
	/**
	 * @var int
	 */
	protected $discountPercent;
	
	/**
	 * @var int
	 */
	protected $hits;
	
	/**
	 * @var bool
	 */
	protected $enabled = true;
	
	/**
	 * @var bool
	 */
	protected $discontinued = false;
	
	/**
	 * @var DateTime
	 */
	protected $dateCreated;
	
	/**
	 * @var DateTime
	 */
	protected $dateModified;
	
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
	 * @return the $productCategoryId
	 */
	public function getProductCategoryId()
	{
		return $this->productCategoryId;
	}

	/**
	 * @param number $productCategoryId
	 */
	public function setProductCategoryId($productCategoryId)
	{
		$this->productCategoryId = $productCategoryId;
		return $this;
	}

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
	 * @return the $taxCodeId
	 */
	public function getTaxCodeId()
	{
		return $this->taxCodeId;
	}

	/**
	 * @param number $taxCodeId
	 */
	public function setTaxCodeId($taxCodeId)
	{
		$this->taxCodeId = $taxCodeId;
		return $this;
	}

	/**
	 * @return the $productPostUnitId
	 */
	public function getProductPostUnitId()
	{
		return $this->productPostUnitId;
	}

	/**
	 * @param number $productPostUnitId
	 */
	public function setProductPostUnitId($productPostUnitId)
	{
		$this->productPostUnitId = $productPostUnitId;
		return $this;
	}

	/**
	 * @return the $productGroupId
	 */
	public function getProductGroupId()
	{
		return $this->productGroupId;
	}

	/**
	 * @param number $productGroupId
	 */
	public function setProductGroupId($productGroupId)
	{
		$this->productGroupId = $productGroupId;
		return $this;
	}

	/**
	 * @return the $productStockStatusId
	 */
	public function getProductStockStatusId()
	{
		return $this->productStockStatusId;
	}

	/**
	 * @param number $productStockStatusId
	 */
	public function setProductStockStatusId($productStockStatusId)
	{
		$this->productStockStatusId = $productStockStatusId;
		return $this;
	}

	/**
	 * @return the $ident
	 */
	public function getIdent()
	{
		return $this->ident;
	}

	/**
	 * @param string $ident
	 */
	public function setIdent($ident)
	{
		$this->ident = $ident;
		return $this;
	}

	/**
	 * @return the $name
	 */
	public function getName() 
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
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

	/**
	 * @return the $description
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}

	/**
	 * @return the $shortDescription
	 */
	public function getShortDescription()
	{
		return $this->shortDescription;
	}

	/**
	 * @param string $shortDescription
	 */
	public function setShortDescription($shortDescription)
	{
		$this->shortDescription = $shortDescription;
		return $this;
	}

	/**
	 * @return the $quantity
	 */
	public function getQuantity()
	{
		return $this->quantity;
	}

	/**
	 * @param number $quantity
	 */
	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;
		return $this;
	}

	/**
	 * @return the $taxable
	 */
	public function getTaxable()
	{
		return $this->taxable;
	}

	/**
	 * @param boolean $taxable
	 */
	public function setTaxable($taxable)
	{
		$this->taxable = $taxable;
		return $this;
	}

	/**
	 * @return the $addPostage
	 */
	public function getAddPostage()
	{
		return $this->addPostage;
	}

	/**
	 * @param boolean $addPostage
	 */
	public function setAddPostage($addPostage)
	{
		$this->addPostage = $addPostage;
		return $this;
	}

	/**
	 * @return the $discountPercent
	 */
	public function getDiscountPercent()
	{
		return $this->discountPercent;
	}

	/**
	 * @param number $discountPercent
	 */
	public function setDiscountPercent($discountPercent)
	{
		$this->discountPercent = $discountPercent;
		return $this;
	}

	/**
	 * @return the $hits
	 */
	public function getHits()
	{
		return $this->hits;
	}

	/**
	 * @param number $hits
	 */
	public function setHits($hits)
	{
		$this->hits = $hits;
		return $this;
	}

	/**
	 * @return the $enabled
	 */
	public function getEnabled()
	{
		return $this->enabled;
	}

	/**
	 * @param boolean $enabled
	 */
	public function setEnabled($enabled)
	{
		$this->enabled = $enabled;
		return $this;
	}

	/**
	 * @return the $discontinued
	 */
	public function getDiscontinued()
	{
		return $this->discontinued;
	}

	/**
	 * @param boolean $discontinued
	 */
	public function setDiscontinued($discontinued)
	{
		$this->discontinued = $discontinued;
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

}
