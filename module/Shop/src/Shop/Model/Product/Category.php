<?php
namespace Shop\Model\Product;

use UthandoCommon\Model\DateCreatedTrait;
use UthandoCommon\Model\DateModifiedTrait;
use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;
use UthandoCommon\Model\NestedSet;

class Category extends NestedSet implements ModelInterface
{
    use Model, DateModifiedTrait, DateCreatedTrait;
    
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
	 * @var bool
	 */
	protected $enabled = true;
	
	/**
	 * @var bool
	 */
	protected $discontinued = false;

    /**
     * @return int
     */
    public function getProductCategoryId()
	{
		return $this->productCategoryId;
	}

    /**
     * @param $productCategoryId
     * @return $this
     */
    public function setProductCategoryId($productCategoryId)
	{
		$this->productCategoryId = $productCategoryId;
		return $this;
	}

    /**
     * @return int
     */
    public function getProductImageId()
	{
		return $this->productImageId;
	}

    /**
     * @param $productImageId
     * @return $this
     */
    public function setProductImageId($productImageId)
	{
		$this->productImageId = $productImageId;
		return $this;
	}

    /**
     * @return string
     */
    public function getIdent()
	{
		return $this->ident;
	}

    /**
     * @param $ident
     * @return $this
     */
    public function setIdent($ident)
	{
		$this->ident = $ident;
		return $this;
	}

    /**
     * @return string
     */
    public function getCategory()
	{
		return $this->category;
	}

    /**
     * @param $category
     * @return $this
     */
    public function setCategory($category)
	{
		$this->category = $category;
		return $this;
	}

    /**
     * @return bool
     */
    public function getEnabled()
	{
		return $this->enabled;
	}

    /**
     * @param $enabled
     * @return $this
     */
    public function setEnabled($enabled)
	{
		$enabled = (bool) $enabled;
		$this->enabled = $enabled;
		return $this;
	}

    /**
     * @return bool
     */
    public function getDiscontinued()
	{
		return $this->discontinued;
	}

    /**
     * @param $discontinued
     * @return $this
     */
    public function setDiscontinued($discontinued)
	{
		$discontinued = (bool) $discontinued;
		$this->discontinued = $discontinued;
		return $this;
	}
}
