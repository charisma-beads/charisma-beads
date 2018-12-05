<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Model\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Model;


use UthandoCommon\Model\DateCreatedTrait;
use UthandoCommon\Model\DateModifiedTrait;
use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

/**
 * Class Product
 *
 * @package Shop\Model
 */
class ProductModel implements ModelInterface
{
    use Model,
        ProductImageTrait,
        ProductOptionTrait,
        DateCreatedTrait,
        DateModifiedTrait;
    
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
	 * @var string
	 */
	protected $sku;
	
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
	protected $quantity = -1;
	
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
	protected $hits = 0;
	
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
	 * @var bool
	 */
	protected  $showImage;
	
	/**
	 * @var ProductCategoryModel
	 */
	protected $productCategory;
	
	/**
	 * @var ProductSizeModel
	 */
	protected $productSize;
	
	/**
	 * @var TaxCodeModel
	 */
	protected $taxCode;
	
	/**
	 * @var PostUnitModel
	 */
	protected $postUnit;
	
	/**
	 * @var ProductGroupModel
	 */
	protected $productGroup;
	
	/**
	 * @return number $productId
	 */
	public function getProductId ()
	{
		return $this->productId;
	}

    /**
     * @param $productId
     * @return $this
     */
    public function setProductId($productId)
	{
		$this->productId = $productId;
		return $this;
	}

	/**
	 * @return number $productCategoryId
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
	 * @return number $productSizeId
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
	 * @return number $taxCodeId
	 */
	public function getTaxCodeId()
	{
		return $this->taxCodeId;
	}

    /**
     * @param $taxCodeId
     * @return $this
     */
    public function setTaxCodeId($taxCodeId)
	{
		$this->taxCodeId = $taxCodeId;
		return $this;
	}

	/**
	 * @return number $productPostUnitId
	 */
	public function getPostUnitId()
	{
		return $this->postUnitId;
	}

    /**
     * @param $postUnitId
     * @return $this
     */
    public function setPostUnitId($postUnitId)
	{
		$this->postUnitId = $postUnitId;
		return $this;
	}

	/**
	 * @return number $productGroupId
	 */
	public function getProductGroupId()
	{
		return $this->productGroupId;
	}

    /**
     * @param $productGroupId
     * @return $this
     */
    public function setProductGroupId($productGroupId)
	{
		$this->productGroupId = $productGroupId;
		return $this;
	}

	/**
     * @return string $sku
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     * @return $this
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
        return $this;
    }

    /**
	 * @return string $ident
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
	 * @return string $name
	 */
	public function getName()
	{
		return $this->name;
	}

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

    /**
     * @param bool $withDiscount
     * @return float
     */
    public function getPrice($withDiscount = true)
	{
        // if group price is set, use that instead.
	    $price = ($this->getProductGroup() instanceof ProductGroupModel && $this->getProductGroup()->getPrice()) ?
            $this->getProductGroup()->getPrice() : $this->price;
	    
	    if (true === $this->isDiscounted() && true === $withDiscount) {
	    	$discount = $this->getDiscountPercent();
	    	$discounted = ($price * $discount) / 100;
	    	$price = round($price - $discounted, 2);
	    }
	    
		return $price;
	}

    /**
     * @param $price
     * @return $this
     */
    public function setPrice($price)
	{
		$this->price = $price;
		return $this;
	}

	/**
	 * @return string $description
	 */
	public function getDescription()
	{
		return $this->description;
	}

    /**
     * @param $description
     * @return $this
     */
    public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}

	/**
	 * @return string $shortDescription
	 */
	public function getShortDescription()
	{
		return $this->shortDescription;
	}

    /**
     * @param $shortDescription
     * @return $this
     */
    public function setShortDescription($shortDescription)
	{
		$this->shortDescription = $shortDescription;
		return $this;
	}

	/**
	 * @return number $quantity
	 */
	public function getQuantity()
	{
		return $this->quantity;
	}

    /**
     * @param $quantity
     * @return $this
     */
    public function setQuantity($quantity)
	{
		$this->quantity = $quantity;
		return $this;
	}

	/**
	 * @return boolean $taxable
	 */
	public function getTaxable()
	{
		return $this->taxable;
	}

    /**
     * @param $taxable
     * @return $this
     */
    public function setTaxable($taxable)
	{
		$this->taxable = $taxable;
		return $this;
	}

	/**
	 * @return boolean $addPostage
	 */
	public function getAddPostage()
	{
		return $this->addPostage;
	}

    /**
     * @param $addPostage
     * @return $this
     */
    public function setAddPostage($addPostage)
	{
		$this->addPostage = $addPostage;
		return $this;
	}

    /**
     * @param bool $formatPercent
     * @return float|int
     */
    public function getDiscountPercent($formatPercent=false)
	{
		return (true === $formatPercent) ? 1 + ($this->discountPercent / 100) : $this->discountPercent;
	}

    /**
     * @param $discountPercent
     * @return $this
     */
    public function setDiscountPercent($discountPercent)
	{
		$this->discountPercent = $discountPercent;
		return $this;
	}

	/**
	 * @return number $hits
	 */
	public function getHits()
	{
		return $this->hits;
	}

    /**
     * @param $hits
     * @return $this
     */
    public function setHits($hits)
	{
		$this->hits = $hits;
		return $this;
	}

	/**
	 * @return boolean $enabled
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
		$this->enabled = $enabled;
		return $this;
	}

	/**
	 * @return boolean $discontinued
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
		$this->discontinued = $discontinued;
		return $this;
	}

	/**
	 * @return boolean $vatInc
	 */
	public function getVatInc()
	{
		return $this->vatInc;
	}

    /**
     * @param $vatInc
     * @return $this
     */
    public function setVatInc($vatInc)
	{
		$this->vatInc = $vatInc;
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

    /**
     * @return bool
     */
    public function isDiscounted()
    {
        return (0 == $this->getDiscountPercent()) ? false : true;
    }

    /**
     * @return bool
     */
    public function inStock()
    {
        return ($this->getQuantity() == 0) ? false : true;
    }
    
    /**
     * @return ProductCategoryModel
     */
	public function getProductCategory()
    {
        return $this->productCategory;
    }

    /**
     * @param ProductCategoryModel $productCategory
     * @return $this
     */
    public function setProductCategory(ProductCategoryModel $productCategory)
    {
        $this->productCategory = $productCategory;
        return $this;
    }

    /**
     * @return ProductSizeModel
     */
	public function getProductSize()
    {
        return $this->productSize;
    }

    /**
     * @param ProductSizeModel $productSize
     * @return $this
     */
    public function setProductSize(ProductSizeModel $productSize)
    {
        $this->productSize = $productSize;
        return $this;
    }

    /**
     * @return TaxCodeModel
     */
	public function getTaxCode()
    {
        return $this->taxCode;
    }

    /**
     * @param TaxCodeModel $taxCode
     * @return $this
     */
    public function setTaxCode(TaxCodeModel $taxCode)
    {
        $this->taxCode = $taxCode;
        return $this;
    }

    /**
     * @return PostUnitModel
     */
	public function getPostUnit()
    {
        return $this->postUnit;
    }

    /**
     * @param PostUnitModel $postUnit
     * @return $this
     */
    public function setPostUnit(PostUnitModel $postUnit)
    {
        $this->postUnit = $postUnit;
        return $this;
    }

    /**
     * @return ProductGroupModel
     */
	public function getProductGroup()
    {
        return $this->productGroup;
    }

    /**
     * @param ProductGroupModel $productGroup
     * @return $this
     */
    public function setProductGroup(ProductGroupModel $productGroup)
    {
        $this->productGroup = $productGroup;
        return $this;
    }
}
