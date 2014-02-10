<?php
namespace Shop\Model\Order;

use Application\Model\Model;
use Application\Model\ModelInterface;

class Line implements ModelInterface
{
    use Model;
    
    /**
     * @var int
     */
    protected $orderLineId;
    
    /**
     * @var int
     */
    protected $orderId;
    
    /**
     * @var int
     */
    protected $productId;
    
    /**
     * @var int
     */
    protected $qty = 0;
    
    /**
     * @var float
     */
    protected $price = 0.00;
    
    /**
     * @var float
     */
    protected $vatPercent = 0.00;
    
	/**
	 * @return number $orderLineId
	 */
	public function getOrderLineId ()
	{
		return $this->orderLineId;
	}

	/**
	 * @param number $orderLineId
	 */
	public function setOrderLineId ($orderLineId)
	{
		$this->orderLineId = $orderLineId;
		return $this;
	}

	/**
	 * @return number $orderId
	 */
	public function getOrderId ()
	{
		return $this->orderId;
	}

	/**
	 * @param number $orderId
	 */
	public function setOrderId ($orderId)
	{
		$this->orderId = $orderId;
		return $this;
	}

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
	 * @return number $qty
	 */
	public function getQty ()
	{
		return $this->qty;
	}

	/**
	 * @param number $qty
	 */
	public function setQty ($qty)
	{
		$this->qty = $qty;
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
	 * @return number $vatPercent
	 */
	public function getVatPercent ()
	{
		return $this->vatPercent;
	}

	/**
	 * @param number $vatPercent
	 */
	public function setVatPercent ($vatPercent)
	{
		$this->vatPercent = $vatPercent;
		return $this;
	}

}
