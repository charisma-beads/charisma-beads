<?php
namespace Shop\Options;

use Zend\Stdlib\AbstractOptions;

class CartCookieOptions extends AbstractOptions
{
    /**
     * @var int
     */
    protected $expiry;
    
    /**
     * @var string
     */
    protected $domain;
    
    /**
     * @var string
     */
    protected $url;
    
    /**
     * @var boolean
     */
    protected $secure;
    
    /**
     * @var string
     */
    protected $cookieName;
    
	/**
	 * @return number
	 */
    public function getExpiry()
    {
        return $this->expiry;
    }

	/**
	 * @param unknown $expiry
	 * @return \Shop\Options\CartCookieOptions
	 */
    public function setExpiry($expiry)
    {
        $this->expiry = $expiry;
        return $this;
    }

	/**
	 * @return string
	 */
    public function getDomain()
    {
        return $this->domain;
    }

	/**
	 * @param string $domain
	 * @return \Shop\Options\CartCookieOptions
	 */
    public function setDomain($domain)
    {
        $this->domain = $domain;
        return $this;
    }

	/**
	 * @return string
	 */
    public function getUrl()
    {
        return $this->url;
    }

	/**
	 * @param string $url
	 * @return \Shop\Options\CartCookieOptions
	 */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

	/**
	 * @return boolean
	 */
    public function getSecure()
    {
        return $this->secure;
    }

	/**
	 * @param unknown $secure
	 * @return \Shop\Options\CartCookieOptions
	 */
    public function setSecure($secure)
    {
        $this->secure = $secure;
        return $this;
    }
    
	/**
	 * @return string
	 */
    public function getCookieName()
    {
        return $this->cookieName;
    }

	/**
	 * @param string $cookieName
	 * @return \Shop\Options\CartCookieOptions
	 */
    public function setCookieName($cookieName)
    {
        $this->cookieName = $cookieName;
        return $this;
    }
}
