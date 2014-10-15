<?php
namespace Shop\Model\Order;

use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;
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
     * @var ProductMetaData
     */
    protected $metadata;

    /**
     * @return int
     */
	public function getOrderLineId()
	{
		return $this->orderLineId;
	}

    /**
     * @param $orderLineId
     * @return $this
     */
	public function setOrderLineId($orderLineId)
	{
		$this->orderLineId = $orderLineId;
		return $this;
	}

    /**
     * @return int
     */
	public function getOrderId()
	{
		return $this->orderId;
	}

    /**
     * @param $orderId
     * @return $this
     */
	public function setOrderId($orderId)
	{
		$this->orderId = $orderId;
		return $this;
	}

    /**
     * @return int
     */
	public function getQty()
	{
		return $this->qty;
	}

    /**
     * @param $qty
     * @return $this
     */
	public function setQty($qty)
	{
		$this->qty = $qty;
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
     * @return float
     */
	public function getTax()
	{
		return $this->tax;
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
