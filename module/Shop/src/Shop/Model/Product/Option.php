<?php
namespace Shop\Model\Product;

use Shop\Model\Post\Unit;
use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

class Option implements ModelInterface
{
    use Model;
    
	/**
	 * @var int
	 */
	protected $productOptionId;
	
	/**
	 * @var int
	 */
	protected $productId;
	
	/**
	 * @var int $postUnitId
	 */
	protected $postUnitId;
	
	/**
	 * @var string
	 */
	protected $option;
	
	/**
	 * @var float
	 */
	protected $price;

    /**
     * @var int
     */
    protected $discountPercent;

    /**
     * @var \Shop\Model\Post\Unit
     */
    protected $postUnit;

    /**
     * @return int
     */
    public function getProductOptionId()
	{
		return $this->productOptionId;
	}

    /**
     * @param $productOptionId
     * @return $this
     */
    public function setProductOptionId($productOptionId)
	{
		$this->productOptionId = $productOptionId;
		return $this;
	}

    /**
     * @return int
     */
    public function getProductId()
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
     * @return int
     */
    public function getPostUnitId()
	{
		return $this->postUnitId;
	}

	/**
	 * @param number $postUnitId
	 */
	public function setPostUnitId($postUnitId)
	{
		$this->postUnitId = $postUnitId;
	}

    /**
     * @return string
     */
    public function getOption()
	{
		return $this->option;
	}

    /**
     * @param $option
     * @return $this
     */
    public function setOption($option)
	{
		$this->option = $option;
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
     * @return bool
     */
    public function isDiscounted()
    {
        return (0 == $this->getDiscountPercent()) ? false : true;
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
}
