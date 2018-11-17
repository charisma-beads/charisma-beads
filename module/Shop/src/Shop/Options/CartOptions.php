<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Options
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Class CartOptions
 *
 * @package Shop\Options
 */
class CartOptions extends AbstractOptions
{
    /**
     * @var boolean
     */
    protected $payCheck;
    
    /**
     * @var boolean
     */
    protected $collectInstore;
    
    /**
     * @var boolean
     */
    protected $payCreditCard;
    
    /**
     * @var boolean
     */
    protected $payPhone;
    
    /**
     * @var boolean
     */
    protected $payPaypal;

    /**
     * @var bool
     */
    protected $autoIncrementCart;

    /**
     * @var boolean
     */
    protected $shippingByWeight;
    
	/**
	 * @return boolean $PayCheck
	 */
	public function getPayCheck()
	{
		return $this->payCheck;
	}

    /**
     * @param boolean $payCheck
     * @return $this
     */
	public function setPayCheck($payCheck)
	{
		$this->payCheck = $payCheck;
		return $this;
	}

	/**
	 * @return boolean $CollectInstore
	 */
	public function getCollectInstore()
	{
		return $this->collectInstore;
	}

    /**
     * @param boolean $collectInstore
     * @return $this
     */
	public function setCollectInstore($collectInstore)
	{
		$this->collectInstore = $collectInstore;
		return $this;
	}

	/**
	 * @return boolean $PayCreditCard
	 */
	public function getPayCreditCard()
	{
		return $this->payCreditCard;
	}

    /**
     * @param $payCreditCard
     * @return $this
     */
	public function setPayCreditCard($payCreditCard)
	{
		$this->payCreditCard = $payCreditCard;
		return $this;
	}

	/**
	 * @return boolean $PayPhone
	 */
	public function getPayPhone()
	{
		return $this->payPhone;
	}

    /**
     * @param $payPhone
     * @return $this
     */
	public function setPayPhone($payPhone)
	{
		$this->payPhone = $payPhone;
		return $this;
	}

	/**
	 * @return boolean $PayPaypal
	 */
	public function getPayPaypal()
	{
		return $this->payPaypal;
	}

    /**
     * @param $payPaypal
     * @return $this
     */
	public function setPayPaypal($payPaypal)
	{
		$this->payPaypal = $payPaypal;
		return $this;
	}

    /**
     * @return boolean
     */
    public function getShippingByWeight()
    {
        return $this->shippingByWeight;
    }

    /**
     * @return boolean
     */
    public function isShippingByWeight()
    {
        return $this->shippingByWeight;
    }

    /**
     * @param boolean $shippingByWeight
     * @return $this
     */
    public function setShippingByWeight($shippingByWeight)
    {
        $this->shippingByWeight = $shippingByWeight;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isAutoIncrementCart()
    {
        return $this->autoIncrementCart;
    }

    /**
     * @return bool
     */
    public function getAutoIncrementCart()
    {
        return $this->autoIncrementCart;
    }

    /**
     * @param boolean $autoIncrementCart
     * @return $this
     */
    public function setAutoIncrementCart($autoIncrementCart)
    {
        $this->autoIncrementCart = (bool) $autoIncrementCart;
        return $this;
    }
}
