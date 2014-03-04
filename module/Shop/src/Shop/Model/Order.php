<?php
namespace Shop\Model;

use Application\Model\Model;
use Application\Model\ModelInterface;
use Shop\Model\Customer;
use Shop\Model\Order\Line;
use Shop\Model\Order\Metadata as OrderMetaData;
use Shop\Model\Order\Status;
use DateTime;

class Order implements ModelInterface
{
    use Model;
    
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
    protected $orderNumber;
    
    /**
     * @var float
     */
    protected $total = 0.00;
    
    /**
     * @var float
     */
    protected $shipping = 0.00;
    
    /**
     * @var float
     */
    protected $taxTotal = 0.00;
    
    /**
     * @var DateTime
     */
    protected $orderDate;
    
    /**
     * @var \Shop\Model\Order\MetaData
     */
    protected $metadata;
    
    /**
     * @var Customer
     */
    protected $customer;
    
    /**
     * @var Status
     */
    protected $orderStatus;
    
    /**
     * @var array|object
     */
    protected $orderLines = array();
    
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
	 * @return number $customerId
	 */
	public function getCustomerId()
	{
		return $this->customerId;
	}

	/**
	 * @param number $customerId
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
	 * @param number $orderStatusId
	 */
	public function setOrderStatusId($orderStatusId)
	{
		$this->orderStatusId = $orderStatusId;
		return $this;
	}

	/**
     * @return the $orderNumber
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

	/**
     * @param int $orderNumber
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;
    }

	/**
	 * @return number $total
	 */
	public function getTotal()
	{
		return $this->total;
	}

	/**
	 * @param number $total
	 */
	public function setTotal($total)
	{
		$this->total = $total;
		return $this;
	}

	/**
	 * @return number $shipping
	 */
	public function getShipping()
	{
		return $this->shipping;
	}

	/**
	 * @param number $shipping
	 */
	public function setShipping($shipping)
	{
		$this->shipping = $shipping;
		return $this;
	}

	/**
	 * @return number $taxTotal
	 */
	public function getTaxTotal()
	{
		return $this->taxTotal;
	}

	/**
	 * @param number $taxTotal
	 */
	public function setTaxTotal($taxTotal)
	{
		$this->taxTotal = $taxTotal;
		return $this;
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
	 */
	public function setOrderDate(DateTime $orderDate = null)
	{
		$this->orderDate = $orderDate;
		return $this;
	}

	/**
	 * @return \Shop\Model\Order\MetaData
	 */
	public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param OrderMetaData $metadata
     * @return \Shop\Model\Order
     */
	public function setMetadata(OrderMetaData $metadata)
    {
        $this->metadata = $metadata;
        return $this;
    }

	/**
     * @return \Shop\Model\Customer
     */
	public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     * @return \Shop\Model\Order
     */
	public function setCustomer($customer)
    {
        $this->customer = $customer;
        return $this;
    }

	/**
     * @return the $orderStatus
     */
    public function getOrderStatus()
    {
        return $this->orderStatus;
    }

	/**
     * @param Status $orderStatus
     */
    public function setOrderStatus(Status $orderStatus)
    {
        $this->orderStatus = $orderStatus;
    }

	/**
     * @return the $orderLines
     */
    public function getOrderLines()
    {
        return $this->orderLines;
    }

	/**
     * @param array|object $orderLine
     */
    public function setOrderLines($orderLines)
    {
        $this->orderLines = $orderLines;
    }
    
    /**
     * @param Line $orderLine
     */
    public function setOrderLine(Line $orderLine)
    {
        $this->orderLines[] = $orderLine;
    }
}
