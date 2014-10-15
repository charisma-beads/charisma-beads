<?php
namespace Shop\Model\Product;

use Shop\Model\Post\Unit;
use Shop\Model\Tax\Code;
use UthandoCommon\Model\DateCreatedTrait;
use UthandoCommon\Model\DateModifiedTrait;
use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

class Product implements ModelInterface
{
    use Model;
    use DateCreatedTrait;
    use DateModifiedTrait;
    
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
	 * @var Category
	 */
	protected $productCategory;
	
	/**
	 * @var Size
	 */
	protected $productSize;
	
	/**
	 * @var Code
	 */
	protected $taxCode;
	
	/**
	 * @var Unit
	 */
	protected $postUnit;
	
	/**
	 * @var Group
	 */
	protected $productGroup;

    /**
     * @var array
     */
    protected $productOption = [];

    /**
     * @var array
     */
    protected $productImage = [];
	
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
	    $price = $this->price;
	    
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
		return (true === $formatPercent) ? $this->discountPercent / 100 : $this->discountPercent;
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
		$this->enabled = $enabled;
		return $this;
	}

	/**
	 * @return boolean $discontinued
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

    public function isDiscounted()
    {
        return (0 == $this->getDiscountPercent()) ? false : true;
    }
    
    /**
     * @return \Shop\Model\Product\Category
     */
	public function getProductCategory()
    {
        return $this->productCategory;
    }

    /**
     * @param Category $productCategory
     * @return $this
     */
    public function setProductCategory(Category $productCategory)
    {
        $this->productCategory = $productCategory;
        return $this;
    }

    /**
     * @return \Shop\Model\Product\Size
     */
	public function getProductSize()
    {
        return $this->productSize;
    }

    /**
     * @param Size $productSize
     * @return $this
     */
    public function setProductSize(Size $productSize)
    {
        $this->productSize = $productSize;
        return $this;
    }

    /**
     * @return \Shop\Model\Tax\Code
     */
	public function getTaxCode()
    {
        return $this->taxCode;
    }

    /**
     * @param Code $taxCode
     * @return $this
     */
    public function setTaxCode(Code $taxCode)
    {
        $this->taxCode = $taxCode;
        return $this;
    }

    /**
     * @return \Shop\Model\Post\Unit
     */
	public function getPostUnit()
    {
        return $this->postUnit;
    }

    /**
     * @param Unit $postUnit
     * @return $this
     */
    public function setPostUnit(Unit $postUnit)
    {
        $this->postUnit = $postUnit;
        return $this;
    }

    /**
     * @return \Shop\Model\Product\Group
     */
	public function getProductGroup()
    {
        return $this->productGroup;
    }

    /**
     * @param Group $productGroup
     * @return $this
     */
    public function setProductGroup(Group $productGroup)
    {
        $this->productGroup = $productGroup;
        return $this;
    }

    /**
     * @param Option $productOption
     */
    public function setProductOption($productOption)
    {
        if ($productOption instanceof Option) {
            $productOption[] = [$productOption];
        }

        $this->productOption = $productOption;
    }

    /**
     * @param int|null $id
     * @return array|null|Option
     */
    public function getProductOption($id = null)
    {
        $productOptionOrOptions = null;

        if (is_int($id)) {
            /* @var $option Option */
            foreach ($this->productOption as $option) {
                if ($id === $option->getProductOptionId()) {
                    $productOptionOrOptions = $option;
                    break;
                }
            }
        } else {
            $productOptionOrOptions = $this->productOption;
        }

        return $productOptionOrOptions;
    }

    /**
     * @return array
     */
    public function getProductImage()
    {
        return $this->productImage;
    }

    /**
     * @param $images
     * @return $this
     */
    public function setProductImage($images)
    {
        if ($images instanceof Image) {
            $images = [$images];
        }

        $this->productImage = $images;

        return $this;
    }
}
