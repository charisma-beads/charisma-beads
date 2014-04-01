<?php
namespace Shop\Model\Order;

use Application\Model\Model;
use Application\Model\ModelInterface;
use Shop\Model\Product\MetaData as ProductMetaData;

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
    protected $qty = 0;
    
    /**
     * @var float
     */
    protected $price = 0.00;
    
    /**
     * @var float
     */
    protected $tax = 0.00;
    
    /**
     * @var \Shop\Model\Product\MetaData
     */
    protected $metadata;
    
	/**
	 * @return number $orderLineId
	 */
	public function getOrderLineId()
	{
		return $this->orderLineId;
	}

	/**
	 * @param number $orderLineId
	 */
	public function setOrderLineId($orderLineId)
	{
		$this->orderLineId = $orderLineId;
		return $this;
	}

	/**
	 * @return number $orderId
	 */
	public function getOrderId()
	{
		return $this->orderId;
	}

	/**
	 * @param number $orderId
	 */
	public function setOrderId($orderId)
	{
		$this->orderId = $orderId;
		return $this;
	}

	/**
	 * @return number $qty
	 */
	public function getQty()
	{
		return $this->qty;
	}

	/**
	 * @param number $qty
	 */
	public function setQty($qty)
	{
		$this->qty = $qty;
		return $this;
	}

	/**
	 * @return number $price
	 */
	public function getPrice()
	{
		return $this->price;
	}

	/**
	 * @param number $price
	 */
	public function setPrice($price)
	{
		$this->price = $price;
		return $this;
	}

	/**
	 * @return number $tax
	 */
	public function getTax()
	{
		return $this->tax;
	}

	/**
	 * @param number $tax
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
	 * @param ProductMetaData $metadata
	 * @return \Shop\Model\Order\Line
	 */
	public function setMetadata(ProductMetaData $metadata)
	{
	    $this->metadata = $metadata;
	    return $this;
	}
}
