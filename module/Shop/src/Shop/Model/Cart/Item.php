<?php
namespace Shop\Model\Cart;

use UthandoCommon\Model\ModelInterface;
use UthandoCommon\Model\Model;
use Shop\Model\Product\MetaData as ProductMetaData;

class Item implements ModelInterface
{   
    use Model;
    
    /**
     * @var int
     */
    protected $cartItemId;
    
    /**
     * @var int
     */
    protected $cartId;
    
    /**
     * @var int
     */
	protected $quantity;
	
	/**
	 * @var float
	 */
	protected $price;
	
	/**
	 * @var float
	 */
	protected $tax;
	
	/**
	 * @var ProductMetaData
	 */
	protected $metadata;
	
	/**
	 * @return number
	 */
    public function getCartItemId()
    {
        return $this->cartItemId;
    }

    /**
     * @param $cartItemId
     * @return $this
     */
    public function setCartItemId($cartItemId)
    {
        $this->cartItemId = $cartItemId;
        return $this;
    }

    /**
     * @return int
     */
    public function getCartId()
    {
        return $this->cartId;
    }

    /**
     * @param $cartId
     * @return $this
     */
    public function setCartId($cartId)
    {
        $this->cartId = $cartId;
        return $this;
    }

    /**
     * @return int
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
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
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
     * @return float
     */
    public function getTax($formatPercent=false)
	{
		return (true === $formatPercent) ? $this->tax / 100 : $this->tax;
    }

    /**
     * @param $tax
     * @return $this
     */
    public function setTax($tax)
    {
        $this->tax = $tax;
        return $this;
    }

    /**
     * @return ProductMetaData
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param ProductMetaData $metadata
     * @return $this
     */
    public function setMetadata(ProductMetaData $metadata)
    {
        $this->metadata = $metadata;
        return $this;
    }
}
