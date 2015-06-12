<?php
namespace Shop\Model\Order;

use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;
use Shop\Model\Customer\Customer;
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
    protected $orderNumber = 0;
    
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
     * @var MetaData
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
     * @var array
     */
    protected $orderLines = array();

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
     * @return float
     */
	public function getTotal()
	{
		return $this->total;
	}

    /**
     * @param $total
     * @return $this
     */
	public function setTotal($total)
	{
		$this->total = $total;
		return $this;
	}

    /**
     * @return float
     */
	public function getShipping()
	{
		return $this->shipping;
	}

    /**
     * @param $shipping
     * @return $this
     */
	public function setShipping($shipping)
	{
		$this->shipping = $shipping;
		return $this;
	}

    /**
     * @return float
     */
	public function getTaxTotal()
	{
		return $this->taxTotal;
	}

    /**
     * @param $taxTotal
     * @return $this
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
     * @return $this
     */
	public function setOrderDate(DateTime $orderDate = null)
	{
		$this->orderDate = $orderDate;
		return $this;
	}

    /**
     * @return MetaData
     */
	public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param Metadata $metadata
     * @return $this
     */
	public function setMetadata(MetaData $metadata)
    {
        $this->metadata = $metadata;
        return $this;
    }

    /**
     * @return Customer
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
     * @return Status
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
     * @return array
     */
    public function getOrderLines()
    {
        return $this->orderLines;
    }

    /**
     * @param $orderLines
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
