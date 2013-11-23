<?php
namespace Shop\Options;

use Zend\Stdlib\AbstractOptions;

class CheckoutOptions extends AbstractOptions
{
    /**
     * @var boolean
     */
    protected $PayCheck;
    
    /**
     * @var boolean
     */
    protected $CollectInstore;
    
    /**
     * @var boolean
     */
    protected $PayCreditCard;
    
    /**
     * @var boolean
     */
    protected $PayPhone;
    
    /**
     * @var boolean
     */
    protected $PayPaypal;
    
	/**
	 * @return boolean $PayCheck
	 */
	public function getPayCheck()
	{
		return $this->PayCheck;
	}

	/**
	 * @param boolean $PayCheck
	 */
	public function setPayCheck($PayCheck)
	{
		$this->PayCheck = $PayCheck;
		return $this;
	}

	/**
	 * @return boolean $CollectInstore
	 */
	public function getCollectInstore()
	{
		return $this->CollectInstore;
	}

	/**
	 * @param boolean $CollectInstore
	 */
	public function setCollectInstore($CollectInstore)
	{
		$this->CollectInstore = $CollectInstore;
		return $this;
	}

	/**
	 * @return boolean $PayCreditCard
	 */
	public function getPayCreditCard()
	{
		return $this->PayCreditCard;
	}

	/**
	 * @param boolean $PayCreditCard
	 */
	public function setPayCreditCard($PayCreditCard)
	{
		$this->PayCreditCard = $PayCreditCard;
		return $this;
	}

	/**
	 * @return boolean $PayPhone
	 */
	public function getPayPhone()
	{
		return $this->PayPhone;
	}

	/**
	 * @param boolean $PayPhone
	 */
	public function setPayPhone($PayPhone)
	{
		$this->PayPhone = $PayPhone;
		return $this;
	}

	/**
	 * @return boolean $PayPaypal
	 */
	public function getPayPaypal()
	{
		return $this->PayPaypal;
	}

	/**
	 * @param boolean $PayPaypal
	 */
	public function setPayPaypal($PayPaypal)
	{
		$this->PayPaypal = $PayPaypal;
		return $this;
	}
}
