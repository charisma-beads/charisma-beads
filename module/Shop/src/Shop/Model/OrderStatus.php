<?php
namespace Shop\Model;

use Application\Model\AbstractModel;

class OrderStatus extends AbstractModel
{
    /**
     * @var int
     */
    protected $orderStatusId;
    
    /**
     * @var string
     */
    protected $status;
    
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
	 * @return string $status
	 */
	public function getStatus ()
	{
		return $this->status;
	}

	/**
	 * @param string $status
	 */
	public function setStatus ($status)
	{
		$this->status = $status;
		return $this;
	}
}
