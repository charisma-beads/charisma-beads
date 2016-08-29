<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Model\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Model\Order;

use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

/**
 * Class Line
 *
 * @package Shop\Model\Order
 */
class Line implements ModelInterface, LineInterface
{
    use Model,
        LineTrait;
    
    /**
     * @var int
     */
    protected $orderLineId;
    
    /**
     * @var int
     */
    protected $orderId;

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
}
