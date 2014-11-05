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
     * @var string
     */
    protected $customerNumberPrefix;

    /**
     * @return bool
     */
	public function getAlert()
	{
		return $this->alert;
	}

    /**
     * @param $alert
     * @return $this
     */
	public function setAlert($alert)
	{
		$this->alert = $alert;
		return $this;
	}

    /**
     * @return string
     */
	public function getAlertText()
	{
		return $this->alertText;
	}

    /**
     * @param $alertText
     * @return $this
     */
	public function setAlertText($alertText)
	{
		$this->alertText = $alertText;
		return $this;
	}

    /**
     * @return string
     */
	public function getOrderEmail()
	{
		return $this->orderEmail;
	}

    /**
     * @param $orderEmail
     * @return $this
     */
	public function setOrderEmail($orderEmail)
	{
		$this->orderEmail = $orderEmail;
		return $this;
	}

    /**
     * @return bool
     */
	public function getPostState()
	{
		return $this->postState;
	}

    /**
     * @param $postState
     * @return $this
     */
	public function setPostState($postState)
	{
		$this->postState = $postState;
		return $this;
	}

    /**
     * @return int
     */
	public function getProductsPerPage()
	{
		return $this->productsPerPage;
	}

    /**
     * @param $productsPerPage
     * @return $this
     */
	public function setProductsPerPage($productsPerPage)
	{
		$this->productsPerPage = $productsPerPage;
		return $this;
	}

    /**
     * @return bool
     */
	public function getStockControl()
	{
		return $this->stockControl;
	}

    /**
     * @param $stockControl
     * @return $this
     */
	public function setStockControl($stockControl)
	{
		$this->stockControl = $stockControl;
		return $this;
	}

    /**
     * @return string
     */
	public function getVatNumber()
	{
		return $this->vatNumber;
	}

    /**
     * @param $vatNumber
     * @return $this
     */
	public function setVatNumber($vatNumber)
	{
		$this->vatNumber = $vatNumber;
		return $this;
	}

    /**
     * @return bool
     */
	public function getVatState()
	{
		return $this->vatState;
	}

    /**
     * @param $vatState
     * @return $this
     */
	public function setVatState($vatState)
	{
		$this->vatState = $vatState;
		return $this;
	}

    /**
     * @return string
     */
    public function getCustomerNumberPrefix()
    {
        return $this->customerNumberPrefix;
    }

    /**
     * @param $customerNumberPrefix
     * @return $this
     */
    public function setCustomerNumberPrefix($customerNumberPrefix)
    {
        $this->customerNumberPrefix = $customerNumberPrefix;
        return $this;
    }
}
