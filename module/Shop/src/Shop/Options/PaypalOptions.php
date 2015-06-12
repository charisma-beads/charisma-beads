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
 * Class PaypalOptions
 *
 * @package Shop\Options
 */
class PaypalOptions extends AbstractOptions
{   
    /**
     * @var string
     */
    protected $currencyCode;
    
    /**
     * @var string
     */
    protected $mode = 'sandbox';
    
    /**
     * @var bool
     */
    protected $logEnabled = false;
    
    /**
     * @var bool
     */
    protected $log = './data/PayPal.log';
    
    /**
     * Logging level can be one of FINE, INFO, WARN or ERROR
     * Logging is most verbose in the 'FINE' level and
     * decreases as you proceed towards ERROR
     * 
     * @var string
     */
    protected  $logLevel = 'FINE';
    
    /**
     * @var string
     */
    protected $clientId;
    
    /**
     * @var string
     */
    protected $secret;
    
    /**
     * @var string
     */
    protected $paymentMethod = 'paypal';

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
	 * @return string $mode
	 */
	public function getMode()
	{
		return $this->mode;
	}

	/**
	 * @param string $mode
	 */
	public function setMode($mode)
	{
		$this->mode = $mode;
		return $this;
	}

	/**
	 * @return boolean
	 */
	public function getLogEnabled()
	{
		return $this->logEnabled;
	}

	/**
	 * @param boolean $logEnabled
	 */
	public function setLogEnabled($logEnabled)
	{
		$this->logEnabled = $logEnabled;
	}

	/**
	 * @return boolean
	 */
	public function getLog()
	{
		return $this->log;
	}
	
	/**
	 * @param boolean $log
	 */
	public function setLog($log)
	{
		$this->log = $log;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getLogLevel()
	{
		return $this->logLevel;
	}

	/**
	 * @param string $logLevel
	 */
	public function setLogLevel($logLevel)
	{
		$this->logLevel = $logLevel;
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
	 */
	public function setPaymentMethod($paymentMethod)
	{
		$this->paymentMethod = $paymentMethod;
	}
	
	/**
	 * @return string
	 */
	public function getClientId()
	{
		return $this->clientId;
	}

	/**
	 * @param string $clientId
	 */
	public function setClientId($clientId)
	{
		$this->clientId = $clientId;
	}

	/**
	 * @return string
	 */
	public function getSecret()
	{
		return $this->secret;
	}

	/**
	 * @param string $secret
	 */
	public function setSecret($secret)
	{
		$this->secret = $secret;
	}
}
