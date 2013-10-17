<?php
namespace Shop\Model;

use Application\Model\AbstractModel;
use DateTime;

class Order extends AbstractModel
{
    /**
     * @var int
     */
    protected $orderId;
    
    /**
     * @var int
     */
    protected $userId;
    
    /**
     * @var int
     */
    protected $orderStatusId;
    
    /**
     * @var string
     */
    protected $txnId;
    
    /**
     * @var float
     */
    protected $total = 0.00;
    
    /**
     * @var DateTime
     */
    protected $orderDate;
    
    /**
     * @var float
     */
    protected $shipping = 0.00;
    
    /**
     * @var float
     */
    protected $vatTotal = 0.00;
    
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
	 * @return number $userId
	 */
	public function getUserId ()
	{
		return $this->userId;
	}

	/**
	 * @param number $userId
	 */
	public function setUserId ($userId)
	{
		$this->userId = $userId;
		return $this;
	}

	/**
	 * @return number $orderStatusId
	 */
	public function getOrderStatusId ()
	{
		return $this->orderStatusId;
	}

	/**
	 * @param number $orderStatusId
	 */
	public function setOrderStatusId ($orderStatusId)
	{
		$this->orderStatusId = $orderStatusId;
		return $this;
	}

	/**
	 * @return string $txnId
	 */
	public function getTxnId ()
	{
		return $this->txnId;
	}

	/**
	 * @param string $txnId
	 */
	public function setTxnId ($txnId)
	{
		$this->txnId = $txnId;
		return $this;
	}

	/**
	 * @return number $total
	 */
	public function getTotal ()
	{
		return $this->total;
	}

	/**
	 * @param number $total
	 */
	public function setTotal ($total)
	{
		$this->total = $total;
		return $this;
	}

	/**
	 * @return DateTime $orderDate
	 */
	public function getOrderDate ()
	{
		return $this->orderDate;
	}

	/**
	 * @param DateTime $orderDate
	 */
	public function setOrderDate ($orderDate)
	{
		$this->orderDate = $orderDate;
		return $this;
	}

	/**
	 * @return number $shipping
	 */
	public function getShipping ()
	{
		return $this->shipping;
	}

	/**
	 * @param number $shipping
	 */
	public function setShipping ($shipping)
	{
		$this->shipping = $shipping;
		return $this;
	}

	/**
	 * @return number $vatTotal
	 */
	public function getVatTotal ()
	{
		return $this->vatTotal;
	}

	/**
	 * @param number $vatTotal
	 */
	public function setVatTotal ($vatTotal)
	{
		$this->vatTotal = $vatTotal;
		return $this;
	}  
}
