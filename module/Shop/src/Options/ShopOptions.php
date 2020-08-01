<?php

namespace Shop\Options;

use Laminas\Stdlib\AbstractOptions;

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
    public function isDevelopmentMode(): bool
    {
        return $this->developmentMode;
    }

    /**
     * @return boolean
     */
    public function getDevelopmentMode(): bool
    {
        return $this->developmentMode;
    }

    /**
     * @param boolean $developmentMode
     * @return $this
     */
    public function setDevelopmentMode(bool $developmentMode)
    {
        $this->developmentMode = $developmentMode;
        return $this;
    }

    /**
     * @return string
     */
    public function getMerchantName(): string
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
	public function getAlert(): bool
	{
		return $this->alert;
	}

    /**
     * @param $alert
     * @return $this
     */
	public function setAlert(bool $alert)
	{
		$this->alert = $alert;
		return $this;
	}

    /**
     * @return string
     */
	public function getAlertText(): string
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
	public function getProductsPerPage(): int
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
	public function setStockControl(bool $stockControl)
	{
		$this->stockControl = $stockControl;
		return $this;
	}

    /**
     * @return string
     */
	public function getVatNumber(): string
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
	public function isVatState(): bool
	{
		return $this->vatState;
	}

    /**
     * @return bool
     */
	public function getVatState(): bool
    {
        return $this->isVatState();
    }

    /**
     * @param $vatState
     * @return $this
     */
	public function setVatState(bool $vatState)
	{
		$this->vatState = $vatState;
		return $this;
	}
}
