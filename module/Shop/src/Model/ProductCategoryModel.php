<?php

namespace Shop\Model;

use Common\Model\DateCreatedTrait;
use Common\Model\DateModifiedTrait;
use Common\Model\Model;
use Common\Model\ModelInterface;
use Common\Model\NestedSet;

/**
 * Class Category
 *
 * @package Shop\Model
 */
class ProductCategoryModel extends NestedSet implements ModelInterface
{
    use Model,
        DateModifiedTrait,
        DateCreatedTrait;

    /**
     * @var int
     */
    protected $productCategoryId;

    /**
     * @var string
     */
    protected $image;
	
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
	 * @var bool
	 */
	protected $showImage;

    /**
     * prints the category when object it converted to a string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getCategory();
    }

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
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return $this
     */
    public function setImage($image)
    {
        $this->image = $image;
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
    public function isEnabled()
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
    public function isDiscontinued()
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
 
    /**
     * @return bool $showImage
     */
    public function getShowImage()
    {
        return $this->showImage;
    }

    /**
     * @param bool $showImage
     * @return $this
     */
    public function setShowImage($showImage)
    {
        $this->showImage = (bool) $showImage;
        return $this;
    }

}
