<?php

namespace Shop\Options;

use Laminas\Stdlib\AbstractOptions;

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
    protected $logEnabled = true;
    
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
	 * api credentials
	 *
	 * @var array
	 */
	protected $credentialPairs = [
		'sandbox'	=> [
			'client_id'	=> '',
			'secret' 	=> '',
		],
		'live'		=> [
			'client_id' 	=> '',
			'secret' 	=> '',
		],
	];
    
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
	 * @param $currencyCode
	 * @return $this
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
	 * @param $mode
	 * @return $this
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
		$this->logEnabled = (bool) $logEnabled;
	}

	/**
	 * @return boolean
	 */
	public function getLog()
	{
		return $this->log;
	}

	/**
	 * @param $log
	 * @return $this
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
     * @param null $mode
     * @return array
     */
	public function getCredentialPairs($mode = null)
	{
        if ($mode) {
            return $this->credentialPairs[$mode];
        }

		return $this->credentialPairs;
	}

	/**
	 * @param array $credentialPairs
	 * @return $this
	 */
	public function setCredentialPairs(array $credentialPairs)
	{
		$this->credentialPairs = $credentialPairs;
		return $this;
	}

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->credentialPairs[$this->mode]['client_id'];
    }

	/**
	 * @return string
	 */
	public function getSecret()
	{
		return $this->credentialPairs[$this->mode]['secret'];
	}
}
