<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Model\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Model;

use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

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
