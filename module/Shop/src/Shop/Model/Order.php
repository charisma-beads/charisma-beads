<?php
namespace Shop\Model;

use Application\Model\Model;
use Application\Model\ModelInterface;
use Shop\Model\Customer;
use Shop\Model\Order\Line;
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
     * @var boolean
     */
    protected $vatInvoice = false;
    
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
	 * @return string $txnId
	 */
	public function getTxnId ()
	{
		return $this->txnId;
	}

	/**
	 * @param string $txnId
	 */
	public function setTxnId($txnId)
	{
		$this->txnId = $txnId;
		return $this;
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
	 * @return number $vatTotal
	 */
	public function getVatTotal()
	{
		return $this->vatTotal;
	}

	/**
	 * @param number $vatTotal
	 */
	public function setVatTotal($vatTotal)
	{
		$this->vatTotal = $vatTotal;
		return $this;
	}
	
	/**
     * @return the $vatInvoice
     */
    public function getVatInvoice()
    {
        return $this->vatInvoice;
    }

	/**
     * @param boolean $vatInvoice
     */
    public function setVatInvoice($vatInvoice)
    {
        $this->vatInvoice = $vatInvoice;
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
