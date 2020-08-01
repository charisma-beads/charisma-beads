<?php

namespace Shop\Model;

use Common\Model\Model;
use Common\Model\ModelInterface;

/**
 * Class Status
 *
 * @package Shop\Model\Order
 */
class OrderStatusModel implements ModelInterface
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
     * @param $orderStatusId
     * @return $this
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
     * @param $orderStatus
     * @return $this
     */
	public function setOrderStatus($orderStatus)
	{
		$this->orderStatus = $orderStatus;
		return $this;
	}
	
	public function __toString()
	{
	    return 'Order Status: ' . $this->getOrderStatus();
	}
}
