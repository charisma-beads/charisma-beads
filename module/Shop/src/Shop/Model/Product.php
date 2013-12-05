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
	protected $postUnitId;
	
	/**
	 * @var int
	 */
	protected $productGroupId;
	
	/**
	 * @var int
	 */
	protected $stockStatusId;
	
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
	 * @var bool
	 */
	protected $vatInc;
	
	/**
	 * @var DateTime
	 */
	protected $dateCreated;
	
	/**
	 * @var DateTime
	 */
	protected $dateModified;
	
	/**
	 * @return number $productId
	 */
	public function getProductId ()
	{
		return $this->productId;
	}

	/**
	 * @param number $productId
	 */
	public function setProductId ($productId)
	{
		$this->productId = $productId;
		return $this;
	}

	/**
	 * @return number $productCategoryId
	 */
	public function getProductCategoryId ()
	{
		return $this->productCategoryId;
	}

	/**
	 * @param number $productCategoryId
	 */
	public function setProductCategoryId ($productCategoryId)
	{
		$this->productCategoryId = $productCategoryId;
		return $this;
	}

	/**
	 * @return number $productSizeId
	 */
	public function getProductSizeId ()
	{
		return $this->productSizeId;
	}

	/**
	 * @param number $productSizeId
	 */
	public function setProductSizeId ($productSizeId)
	{
		$this->productSizeId = $productSizeId;
		return $this;
	}

	/**
	 * @return number $taxCodeId
	 */
	public function getTaxCodeId ()
	{
		return $this->taxCodeId;
	}

	/**
	 * @param number $taxCodeId
	 */
	public function setTaxCodeId ($taxCodeId)
	{
		$this->taxCodeId = $taxCodeId;
		return $this;
	}

	/**
	 * @return number $productPostUnitId
	 */
	public function getPostUnitId ()
	{
		return $this->postUnitId;
	}

	/**
	 * @param number $postUnitId
	 */
	public function setPostUnitId ($postUnitId)
	{
		$this->postUnitId = $postUnitId;
		return $this;
	}

	/**
	 * @return number $productGroupId
	 */
	public function getProductGroupId ()
	{
		return $this->productGroupId;
	}

	/**
	 * @param number $productGroupId
	 */
	public function setProductGroupId ($productGroupId)
	{
		$this->productGroupId = $productGroupId;
		return $this;
	}

	/**
	 * @return number $productStockStatusId
	 */
	public function getStockStatusId ()
	{
		return $this->stockStatusId;
	}

	/**
	 * @param number $stockStatusId
	 */
	public function setStockStatusId ($stockStatusId)
	{
		$this->stockStatusId = $stockStatusId;
		return $this;
	}

	/**
	 * @return string $ident
	 */
	public function getIdent ()
	{
		return $this->ident;
	}

	/**
	 * @param string $ident
	 */
	public function setIdent ($ident)
	{
		$this->ident = $ident;
		return $this;
	}

	/**
	 * @return string $name
	 */
	public function getName ()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName ($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @return number $price
	 */
	public function getPrice ()
	{
		return $this->price;
	}

	/**
	 * @param number $price
	 */
	public function setPrice ($price)
	{
		$this->price = $price;
		return $this;
	}

	/**
	 * @return string $description
	 */
	public function getDescription ()
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription ($description)
	{
		$this->description = $description;
		return $this;
	}

	/**
	 * @return string $shortDescription
	 */
	public function getShortDescription ()
	{
		return $this->shortDescription;
	}

	/**
	 * @param string $shortDescription
	 */
	public function setShortDescription ($shortDescription)
	{
		$this->shortDescription = $shortDescription;
		return $this;
	}

	/**
	 * @return number $quantity
	 */
	public function getQuantity ()
	{
		return $this->quantity;
	}

	/**
	 * @param number $quantity
	 */
	public function setQuantity ($quantity)
	{
		$this->quantity = $quantity;
		return $this;
	}

	/**
	 * @return boolean $taxable
	 */
	public function getTaxable ()
	{
		return $this->taxable;
	}

	/**
	 * @param boolean $taxable
	 */
	public function setTaxable ($taxable)
	{
		$this->taxable = $taxable;
		return $this;
	}

	/**
	 * @return boolean $addPostage
	 */
	public function getAddPostage ()
	{
		return $this->addPostage;
	}

	/**
	 * @param boolean $addPostage
	 */
	public function setAddPostage ($addPostage)
	{
		$this->addPostage = $addPostage;
		return $this;
	}

	/**
	 * @return number $discountPercent
	 */
	public function getDiscountPercent ()
	{
		return $this->discountPercent;
	}

	/**
	 * @param number $discountPercent
	 */
	public function setDiscountPercent ($discountPercent)
	{
		$this->discountPercent = $discountPercent;
		return $this;
	}

	/**
	 * @return number $hits
	 */
	public function getHits ()
	{
		return $this->hits;
	}

	/**
	 * @param number $hits
	 */
	public function setHits ($hits)
	{
		$this->hits = $hits;
		return $this;
	}

	/**
	 * @return boolean $enabled
	 */
	public function getEnabled ()
	{
		return $this->enabled;
	}

	/**
	 * @param boolean $enabled
	 */
	public function setEnabled ($enabled)
	{
		$this->enabled = $enabled;
		return $this;
	}

	/**
	 * @return boolean $discontinued
	 */
	public function getDiscontinued ()
	{
		return $this->discontinued;
	}

	/**
	 * @param boolean $discontinued
	 */
	public function setDiscontinued ($discontinued)
	{
		$this->discontinued = $discontinued;
		return $this;
	}

	/**
	 * @return boolean $vatInc
	 */
	public function getVatInc ()
	{
		return $this->vatInc;
	}

	/**
	 * @param boolean $vatInc
	 */
	public function setVatInc ($vatInc)
	{
		$this->vatInc = $vatInc;
		return $this;
	}

	/**
	 * @return DateTime $dateCreated
	 */
	public function getDateCreated ()
	{
		return $this->dateCreated;
	}

	/**
	 * @param DateTime $dateCreated
	 */
	public function setDateCreated (DateTime $dateCreated)
	{
		$this->dateCreated = $dateCreated;
		return $this;
	}

	/**
	 * @return DateTime $dateModified
	 */
	public function getDateModified ()
	{
		return $this->dateModified;
	}

	/**
	 * @param DateTime $dateModified
	 */
	public function setDateModified (DateTime $dateModified)
	{
		$this->dateModified = $dateModified;
		return $this;
	}


}
