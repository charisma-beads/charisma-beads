<?php
namespace Shop\Model\Cart;

use Application\Model\ModelInterface;
use Application\Model\Model;
use Shop\Model\Product\MetaData as ProductMetaData;
use Shop\Model\Product\MetaData;

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
     * @var string
     */
    protected $description;
    
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
	 * @param int $cartItemId
	 * @return \Shop\Model\Cart\Item
	 */
    public function setCartItemId($cartItemId)
    {
        $this->cartItemId = $cartItemId;
        return $this;
    }

	/**
	 * @return number
	 */
    public function getCartId()
    {
        return $this->cartId;
    }

	/**
	 * @param int $cartId
	 * @return \Shop\Model\Cart\Item
	 */
    public function setCartId($cartId)
    {
        $this->cartId = $cartId;
        return $this;
    }

	/**
	 * @return string
	 */
    public function getDescription()
    {
        return $this->description;
    }

	/**
	 * @param unknown $description
	 * @return \Shop\Model\Cart\Item
	 */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

	/**
	 * @return number
	 */
    public function getQuantity()
    {
        return $this->quantity;
    }

	/**
	 * @param number $quantity
	 * @return \Shop\Model\Cart\Item
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
	 * @param float $price
	 * @return \Shop\Model\Cart\Item
	 */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

	/**
	 * @return float
	 */
    public function getTax()
    {
        return $this->tax;
    }

	/**
	 * @param float $tax
	 * @return \Shop\Model\Cart\Item
	 */
    public function setTax($tax)
    {
        $this->tax = $tax;
        return $this;
    }

	/**
	 * @return \Shop\Model\Product\MetaData
	 */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param MetaData $metadata
     * @return \Shop\Model\Cart\Item
     */
    public function setMetadata(MetaData $metadata)
    {
        $this->metadata = $metadata;
        return $this;
    }
}
