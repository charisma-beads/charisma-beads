<?php
namespace Shop\Model\Product;

use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;
use DateTime;

class Category implements ModelInterface
{
    use Model;
    
	/**
	 * @var int
	 */
	protected $productCategoryId;
	
	/**
	 * @var int
	 */
	protected $productImageId;
	
	/**
	 * @var string
	 */
	protected $ident;
	
	/**
	 * @var string
	 */
	protected $category;
	
	/**
	 * @var int
	 */
	protected $lft;
	
	/**
	 * @var int
	 */
	protected $rgt;
	
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
	 * 
	 * @var DateTime
	 */
	protected $dateModified;
	
	/**
	 * @var int
	 */
	protected $depth;
	
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
	 * @return \Shop\Model\ProductImage
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
	 * @return the $category
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
	 * @return the $lft
	 */
	public function getLft()
	{
		return $this->lft;
	}

	/**
	 * @param number $lft
	 */
	public function setLft($lft)
	{
		$this->lft = $lft;
		return $this;
	}

	/**
	 * @return the $rgt
	 */
	public function getRgt()
	{
		return $this->rgt;
	}

	/**
	 * @param number $rgt
	 */
	public function setRgt($rgt)
	{
		$this->rgt = $rgt;
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
	 * @param number $enabled
	 */
	public function setEnabled($enabled)
	{
		$enabled = (bool) $enabled;
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
	 * @param number $discontinued
	 */
	public function setDiscontinued($discontinued)
	{
		$discontinued = (bool) $discontinued;
		$this->discontinued = $discontinued;
		return $this;
	}

	/**
	 * @return DateTime
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
	 * @return DateTime
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
	
	/**
	 * @return the $depth
	 */
	public function getDepth()
	{
		return $this->depth;
	}

	/**
	 * @param number $depth
	 */
	public function setDepth($depth)
	{
		$this->depth = $depth;
		return $this;
	}
	
	/**
	 * returns true if this category has children
	 * 
	 * @return boolean
	 */
	public function hasChildren()
	{
		$children = (($this->getRgt() - $this->getLft()) - 1) / 2;
		return (0 === $children) ? false : true;
	}
}
