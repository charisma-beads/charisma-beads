<?php
namespace Shop\Model\Order;

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

}
