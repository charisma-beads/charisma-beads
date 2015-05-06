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
     * @var boolean
     */
    protected $postState;
    
    /**
     * @var integer
     */
    protected $productsPerPage;
    
    /**
     * @var string
     */
    protected $productsOrderCol = '-sku';
    
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
     * @var bool
     */
    protected $autoIncrementCart;

    /**
     * @var string
     */
    protected $reportsMemoryLimit;

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
     * @return string $productsOrderCol
     */
    public function getProductsOrderCol()
    {
        return $this->productsOrderCol;
    }

    /**
     * @param string $productsOrderCol
     * @return $this
     */
    public function setProductsOrderCol($productsOrderCol)
    {
        $this->productsOrderCol = $productsOrderCol;
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
     * @return boolean $autoIncrementCart
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
        $this->autoIncrementCart = $autoIncrementCart;
        return $this;
    }

    /**
     * @return string
     */
    public function getReportsMemoryLimit()
    {
        return $this->reportsMemoryLimit;
    }

    /**
     * @param string $reportsMemoryLimit
     * @return $this
     */
    public function setReportsMemoryLimit($reportsMemoryLimit)
    {
        $this->reportsMemoryLimit = $reportsMemoryLimit;

        return $this;
    }
}
