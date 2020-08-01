<?php

namespace Shop\Model;

use Common\Model\Model;
use Common\Model\ModelInterface;

/**
 * Class Line
 *
 * @package Shop\Model\Order
 */
class OrderLineModel implements ModelInterface, OrderLineInterface
{
    use Model,
        OrderLineTrait;

    /**
     * @return int
     */
	public function getOrderLineId()
	{
		return $this->getId();
	}

    /**
     * @param $orderLineId
     * @return $this
     */
	public function setOrderLineId($orderLineId)
	{
		$this->setId($orderLineId);
		return $this;
	}

    /**
     * @return int
     */
	public function getOrderId()
	{
		return $this->getParentId();
	}

    /**
     * @param $orderId
     * @return $this
     */
	public function setOrderId($orderId)
	{
		$this->setParentId($orderId);
		return $this;
	}
}
