<?php
namespace Shop\Options;

use Zend\Stdlib\AbstractOptions;

class PaypalOptions extends AbstractOptions
{
    const SANDBOX_URL   = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    const LIVE_URL      = 'https://www.paypal.com/cgi-bin/webscr';
    
    const RETURN_METHOD_GET_ALL = 0;
    const RETURN_METHOD_GET     = 1;
    const RETURN_METHOD_POST    = 2;
    
    const CURRENCY_CODE_AUSTRALIAN_DOLLAR   = 'AUD';
    const CURRENCY_CODE_POUNDS_STERLING     = 'GBP';
    const CURRENCY_CODE_US_DOLLAR           = 'USD';
    
    /**
     * @var string
     */
    protected $cancelReturnUrl;
    
    /**
     * @var string
     */
    protected $currencyCode;
    
    /**
     * @var string
     */
    protected $deploy;
    
    /**
     * @var string
     */
    protected $imageUrl;
    
    /**
     * @var string
     */
    protected $ipnLog;
    
    /**
     * @var string
     */
    protected $merchantId;
    
    /**
     * @var string
     */
    protected $notifyUrl;
    
    /**
     * @var boolean
     */
    protected $paypalIPN;
    
    /**
     * @var string
     */
    protected $paypalUrl;
    
    /**
     * @var string
     */
    protected $returnUrl;
    
    /**
     * @var integer
     */
    protected $returnMethod;
    
	/**
	 * @return string $cancelReturnUrl
	 */
	public function getCancelReturnUrl()
	{
		return $this->cancelReturnUrl;
	}

	/**
	 * @param string $cancelReturn
	 */
	public function setCancelReturnUrl($cancelReturnUrl)
	{
		$this->cancelReturnUrl = $cancelReturnUrl;
		return $this;
	}

	/**
	 * @return string $currencyCode
	 */
	public function getCurrencyCode()
	{
		return $this->currencyCode;
	}

	/**
	 * @param string $currencyCode
	 */
	public function setCurrencyCode($currencyCode)
	{
		$this->currencyCode = $currencyCode;
		return $this;
	}

	/**
	 * @return string $deploy
	 */
	public function getDeploy()
	{
		return $this->deploy;
	}

	/**
	 * @param string $deploy
	 */
	public function setDeploy($deploy)
	{
		$this->deploy = $deploy;
		return $this;
	}

	/**
	 * @return string $imageUrl
	 */
	public function getImageUrl()
	{
		return $this->imageUrl;
	}

	/**
	 * @param string $imageUrl
	 */
	public function setImageUrl($imageUrl)
	{
		$this->imageUrl = $imageUrl;
		return $this;
	}

	/**
	 * @return string $ipnLog
	 */
	public function getIpnLog()
	{
		return $this->ipnLog;
	}

	/**
	 * @param string $ipnLog
	 */
	public function setIpnLog($ipnLog)
	{
		$this->ipnLog = $ipnLog;
		return $this;
	}

	/**
	 * @return string $merchantId
	 */
	public function getMerchantId()
	{
		return $this->merchantId;
	}

	/**
	 * @param string $merchantId
	 */
	public function setMerchantId($merchantId)
	{
		$this->merchantId = $merchantId;
		return $this;
	}

	/**
	 * @return string $notifyUrl
	 */
	public function getNotifyUrl()
	{
		return $this->notifyUrl;
	}

	/**
	 * @param string $notifyUrl
	 */
	public function setNotifyUrl($notifyUrl)
	{
		$this->notifyUrl = $notifyUrl;
		return $this;
	}

	/**
	 * @return boolean $paypalIPN
	 */
	public function getPaypalIPN()
	{
		return $this->paypalIPN;
	}

	/**
	 * @param boolean $paypalIPN
	 */
	public function setPaypalIPN($paypalIPN)
	{
		$this->paypalIPN = $paypalIPN;
		return $this;
	}

	/**
	 * @return string $paypalUrl
	 */
	public function getPaypalUrl()
	{
	    if ($this->getDeploy() === 'test') {
	    	$this->setPaypalUrl(self::SANDBOX_URL);
	    } else {
	        $this->setPaypalUrl(self::LIVE_URL);
	    }
	    
		return $this->paypalUrl;
	}

	/**
	 * @param string $paypalUrl
	 */
	public function setPaypalUrl($paypalUrl)
	{
		$this->paypalUrl = $paypalUrl;
		return $this;
	}

	/**
	 * @return string $return
	 */
	public function getReturnUrl()
	{
		return $this->returnUrl;
	}

	/**
	 * @param string $return
	 */
	public function setReturnUrl($returnUrl)
	{
		$this->return = $returnUrl;
		return $this;
	}

	/**
	 * @return number $returnMethod
	 */
	public function getReturnMethod()
	{
		return $this->returnMethod;
	}

	/**
	 * @param number $returnMethod
	 */
	public function setReturnMethod($returnMethod)
	{
		$this->returnMethod = $returnMethod;
		return $this;
	}
}
