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

use DateTime;

/**
 * Class Order
 *
 * @package Shop\Model
 */
class OrderModel extends AbstractOrderCollection
{

    protected $entityClass = OrderLineModel::class;
    
    /**
     * @var int
     */
    protected $orderId;
    
    /**
     * @var int
     */
    protected $customerId;
    
    /**
     * @var int
     */
    protected $orderStatusId;
    
    /**
     * @var int
     */
    protected $orderNumber = 0;
    
    /**
     * @var DateTime
     */
    protected $orderDate;

    /**
     * @var OrderMetaDataModel
     */
    protected $metadata;
    
    /**
     * @var CustomerModel
     */
    protected $customer;
    
    /**
     * @var OrderStatusModel
     */
    protected $orderStatus;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->getOrderId();
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
	public function getCustomerId()
	{
		return $this->customerId;
	}

    /**
     * @param $customerId
     * @return $this
     */
	public function setCustomerId($customerId)
	{
		$this->customerId = $customerId;
		return $this;
	}

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
     * @param bool $normaliseNumber
     * @return int
     */
    public function getOrderNumber($normaliseNumber = true)
    {
        $orderNumber = $this->orderNumber;

        if ($normaliseNumber) {
            $orderNumber = ltrim(substr($orderNumber, 8, -1), '0');
        }

        return $orderNumber;
    }

	/**
     * @param int $orderNumber
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;
    }
	
	/**
	 * @return DateTime $orderDate
	 */
	public function getOrderDate()
	{
		return $this->orderDate;
	}

    /**
     * @param DateTime $orderDate
     * @return $this
     */
	public function setOrderDate(DateTime $orderDate = null)
	{
		$this->orderDate = $orderDate;
		return $this;
	}

    /**
     * @return OrderMetaDataModel
     */
	public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param OrderMetaDataModel $metadata
     * @return $this
     */
	public function setMetadata(OrderMetaDataModel $metadata)
    {
        $this->metadata = $metadata;
        return $this;
    }

    /**
     * @return CustomerModel
     */
	public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param $customer
     * @return $this
     */
	public function setCustomer($customer)
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return OrderStatusModel
     */
    public function getOrderStatus()
    {
        return $this->orderStatus;
    }

    /**
     * @param OrderStatusModel $orderStatus
     * @return $this
     */
    public function setOrderStatus(OrderStatusModel $orderStatus)
    {
        $this->orderStatus = $orderStatus;
        return $this;
    }

    /**
     * @return array
     */
    public function getOrderLines()
    {
        return $this->getEntities();
    }

    /**
     * @param $orderLines
     * @return $this
     */
    public function setOrderLines($orderLines)
    {
        $this->setEntities($orderLines);
        return $this;
    }

    /**
     * @param OrderLineModel $orderLine
     * @return $this
     * @throws \Common\Model\CollectionException
     */
    public function setOrderLine(OrderLineModel $orderLine)
    {
        $this->add($orderLine);
        return $this;
    }
}
