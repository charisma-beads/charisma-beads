<?php
namespace Shop\Model\Order;

use Shop\Model\Customer\Address;

class MetaData
{
    /**
     * @var boolean
     */
    protected $taxInvoice = false;
    
    /**
     * @var string
     */
    protected $paymentMethod = 'N\A';
    
    /**
     * @var string
     */
    protected $shippingMethod = 'Royal Mail';
    
    /**
     * @var string
     */
    protected $txnId;
    
    /**
     * @var string
     */
    protected $requirements;
    
    /**
     * @var string
     */
    protected $customerName;
    
    /**
     * @var Shop\Model\Customer\Address
     */
    protected $deliveryAddress;
    
    /**
     * @var Shop\Model\Customer\Address
     */
    protected $billingAddress;
    
    /**
     * @var string
     */
    protected $email;
    
    /**
     * @return boolean
     */
    public function getTaxInvoice()
    {
        return $this->taxInvoice;
    }

    /**
     * @param boolean $taxInvoice
     * @return \Shop\Model\Order\MetaData
     */
	public function setTaxInvoice($taxInvoice)
    {
        $this->taxInvoice = $taxInvoice;
        return $this;
    }

	/**
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }
    
    /**
     * @param string $paymentMethod
     * @return \Shop\Model\Order\MetaData
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getShippingMethod()
    {
        return $this->shippingMethod;
    }
    
    /**
     * @param string $shippingMethod
     * @return \Shop\Model\Order\MetaData
     */
    public function setShippingMethod($shippingMethod)
    {
        $this->shippingMethod = $shippingMethod;
        return $this;
    }
    
    /**
     * @return string
     */
	public function getTxnId()
    {
        return $this->txnId;
    }

    /**
     * @param string $txnId
     * @return \Shop\Model\Order\MetaData
     */
	public function setTxnId($txnId)
    {
        $this->txnId = $txnId;
        return $this;
    }
    
    /**
     * @return string
     */
	public function getRequirements()
    {
        return $this->requirements;
    }

    /**
     * @param string $requirements
     * @return \Shop\Model\Order\MetaData
     */
	public function setRequirements($requirements)
    {
        $this->requirements = $requirements;
        return $this;
    }
    
	public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * @param string $customerName
     * @param string $prefix
     * @return \Shop\Model\Order\MetaData
     */
	public function setCustomerName($customerName, $prefix = null)
    {
        if ($prefix) {
            $prefix = (string) $prefix . ' ';
        }
        
        $this->customerName = $prefix . $customerName;
        return $this;
    }

	public function getDeliveryAddress()
    {
        return $this->deliveryAddress;
    }

    /**
     * @param Address $deliveryAddress
     * @return \Shop\Model\Order\MetaData
     */
	public function setDeliveryAddress(Address $deliveryAddress)
    {
        $this->deliveryAddress = $deliveryAddress;
        return $this;
    }

	public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * @param Address $billingAddress
     * @return \Shop\Model\Order\MetaData
     */
	public function setBillingAddress(Address $billingAddress)
    {
        $this->billingAddress = $billingAddress;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * @param string $email
     * @return \Shop\Model\Order\MetaData
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
}
