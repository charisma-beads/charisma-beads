<?php
namespace Shop\Options;

use Zend\Stdlib\AbstractOptions;

class ShopOptions extends AbstractOptions
{
    /**
     * @var boolean
     */
    protected $alert;
    
    /**
     * @var string
     */
    protected $alertText;
    
    /**
     * @var string
     */
    protected $orderEmail;
    
    /**
     * @var boolean
     */
    protected $postState;
    
    /**
     * @var integer
     */
    protected $productsPerPage;
    
    /**
     * @var boolean
     */
    protected $stockControl;
    
    /**
     * @var string
     */
    protected $vatNumber;
    
    /**
     * @var boolean
     */
    protected $vatState;
    
	/**
	 * @return boolean $alert
	 */
	public function getAlert()
	{
		return $this->alert;
	}

	/**
	 * @param boolean $alert
	 */
	public function setAlert($alert)
	{
		$this->alert = $alert;
		return $this;
	}

	/**
	 * @return string $alertText
	 */
	public function getAlertText()
	{
		return $this->alertText;
	}

	/**
	 * @param string $alertText
	 */
	public function setAlertText($alertText)
	{
		$this->alertText = $alertText;
		return $this;
	}

	/**
	 * @return string $orderEmail
	 */
	public function getOrderEmail()
	{
		return $this->orderEmail;
	}

	/**
	 * @param string $orderEmail
	 */
	public function setOrderEmail($orderEmail)
	{
		$this->orderEmail = $orderEmail;
		return $this;
	}

	/**
	 * @return boolean $postState
	 */
	public function getPostState()
	{
		return $this->postState;
	}

	/**
	 * @param boolean $postState
	 */
	public function setPostState($postState)
	{
		$this->postState = $postState;
		return $this;
	}

	/**
	 * @return number $productsPerPage
	 */
	public function getProductsPerPage()
	{
		return $this->productsPerPage;
	}

	/**
	 * @param number $productsPerPage
	 */
	public function setProductsPerPage($productsPerPage)
	{
		$this->productsPerPage = $productsPerPage;
		return $this;
	}

	/**
	 * @return boolean $stockControl
	 */
	public function getStockControl()
	{
		return $this->stockControl;
	}

	/**
	 * @param boolean $stockControl
	 */
	public function setStockControl($stockControl)
	{
		$this->stockControl = $stockControl;
		return $this;
	}

	/**
	 * @return string $vatNumber
	 */
	public function getVatNumber()
	{
		return $this->vatNumber;
	}

	/**
	 * @param string $vatNumber
	 */
	public function setVatNumber($vatNumber)
	{
		$this->vatNumber = $vatNumber;
		return $this;
	}

	/**
	 * @return boolean $vatState
	 */
	public function getVatState()
	{
		return $this->vatState;
	}

	/**
	 * @param boolean $vatState
	 */
	public function setVatState($vatState)
	{
		$this->vatState = $vatState;
		return $this;
	}
}
