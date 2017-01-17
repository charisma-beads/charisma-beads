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
 * Class ShopOptions
 *
 * @package Shop\Options
 */
class ShopOptions extends AbstractOptions
{
    /**
     * @var bool
     */
	protected $developmentMode;

    /**
     * @var string
     */
    protected $merchantName;

    /**
     * @var boolean
     */
    protected $alert;
    
    /**
     * @var string
     */
    protected $alertText;
    
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
     * @return boolean
     */
    public function isDevelopmentMode()
    {
        return $this->developmentMode;
    }

    /**
     * @param boolean $developmentMode
     * @return $this
     */
    public function setDevelopmentMode($developmentMode)
    {
        $this->developmentMode = $developmentMode;
        return $this;
    }

    /**
     * @return string
     */
    public function getMerchantName()
    {
        return $this->merchantName;
    }

    /**
     * @param string $merchantName
     * @return $this
     */
    public function setMerchantName($merchantName)
    {
        $this->merchantName = $merchantName;
        return $this;
    }

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
	public function isVatState()
	{
		return $this->vatState;
	}

    /**
     * @return bool
     */
	public function getVatState()
    {
        return $this->isVatState();
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
}
