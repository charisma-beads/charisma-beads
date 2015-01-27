<?php
namespace Shop\Model\Order;

use Shop\Model\Customer\Address;

class MetaData
{
    /**
     * @var bool
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
     * @var float
     */
    protected $shippingTax = 0.00;
    
    /**
     * @var string
     */
    protected $paymentId;
    
    /**
     * @var string
     */
    protected $requirements;
    
    /**
     * @var string
     */
    protected $customerName;
    
    /**
     * @var Address
     */
    protected $deliveryAddress;
    
    /**
     * @var Address
     */
    protected $billingAddress;
    
    /**
     * @var string
     */
    protected $email;

    /**
     * @return bool
     */
    public function getTaxInvoice()
    {
        return $this->taxInvoice;
    }

    /**
     * @param bool $taxInvoice
     * @return $this
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
     * @return $this
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
        return $this;
    }

    /**
     * @return float
     */
    public function getShippingTax()
    {
        return $this->shippingTax;
    }

    /**
     * @param float $shippingTax
     * @return $this
     */
    public function setShippingTax($shippingTax)
    {
        $this->shippingTax = $shippingTax;
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
     * @return $this
     */
    public function setShippingMethod($shippingMethod)
    {
        $this->shippingMethod = $shippingMethod;
        return $this;
    }
    
    /**
     * @return string
     */
	public function getPaymentId()
    {
        return $this->paymentId;
    }

    /**
     * @param string $txnId
     * @return $this
     */
	public function setPaymentId($txnId)
    {
        $this->paymentId = $txnId;
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
     * @return $this
     */
	public function setRequirements($requirements)
    {
        $this->requirements = $requirements;
        return $this;
    }

    /**
     * @return string
     */
	public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * @param string $customerName
     * @param null|string $prefix
     * @return $this
     */
	public function setCustomerName($customerName, $prefix = null)
    {
        if ($prefix) {
            $prefix = (string) $prefix . ' ';
        }
        
        $this->customerName = $prefix . $customerName;
        return $this;
    }

    /**
     * @return Address
     */
	public function getDeliveryAddress()
    {
        return $this->deliveryAddress;
    }

    /**
     * @param Address $deliveryAddress
     * @return $this
     */
	public function setDeliveryAddress(Address $deliveryAddress)
    {
        $this->deliveryAddress = $deliveryAddress;
        return $this;
    }

    /**
     * @return Address
     */
	public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * @param Address $billingAddress
     * @return $this
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
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
}
