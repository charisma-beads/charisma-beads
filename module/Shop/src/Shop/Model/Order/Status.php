<?php
namespace Shop\Model\Order;

use Application\Model\Model;
use Application\Model\ModelInterface;

class Status implements ModelInterface
{
    use Model;
    
    /**
     * @var int
     */
    protected $orderStatusId;
    
    /**
     * @var string
     */
    protected $orderStatus;
    
	/**
	 * @return number $orderStatusId
	 */
	public function getOrderStatusId()
	{
		return $this->orderStatusId;
	}

	/**
	 * @param number $orderStatusId
	 */
	public function setOrderStatusId($orderStatusId)
	{
		$this->orderStatusId = $orderStatusId;
		return $this;
	}

	/**
	 * @return string $orderStatus
	 */
	public function getOrderStatus()
	{
		return $this->orderStatus;
	}

	/**
	 * @param string $orderStatus
	 */
	public function setOrderStatus($orderStatus)
	{
		$this->orderStatus = $orderStatus;
		return $this;
	}
}
