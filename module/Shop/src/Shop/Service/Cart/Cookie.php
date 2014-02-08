<?php
namespace Shop\Service\Cart;

use Shop\Options\CartCookieOptions;
use Zend\Http\Header\SetCookie;
use Zend\Http\PhpEnvironment\Request;
use Zend\Http\PhpEnvironment\Response;

class Cookie
{
    /**
     * @var Request
     */
    protected $request;
    
    /**
     * @var Reponse
     */
    protected $response;
    
    /**
     * @var CartCookieOptions
     */
    protected $cookieConfig;
    
    public function retrieveCartVerifierCookie()
    {
        $cookies = $this->getRequest()->getCookie();
        $cookieName = $this->getCookieConfig()->getCookieName();
        
        if (isset($cookies[$cookieName])) {
            return $cookies[$cookieName];
        }
        
        return false;
    }
    
    public function setCartVerifierCookie($verifier = null)
    {
        $verifier = ($verifier) ?: $this->createVerifier();
    
        $cookie = new SetCookie(
            $this->getCookieConfig()->getCookieName(),
            $verifier,
            time() + $this->getCookieConfig()->getExpiry(),
            $this->getCookieConfig()->getUrl(),
            $this->getCookieConfig()->getDomain(),
            $this->getCookieConfig()->getSecure()
        );
        
        $this->getResponse()->getHeaders()->addHeader($cookie);
        
        return $verifier;
    }
    
    public function removeCartVerifierCookie()
    {
        $cookie = new SetCookie(
            $this->getCookieConfig()->getCookieName(),
            null,
            time()-3600,
            $this->getCookieConfig()->getUrl()
        );
        
        $this->getResponse()->getHeaders()->addHeader($cookie);
    }
    
    public function createVerifier()
    {
        return md5(uniqid($this->getCookieConfig()->getCookieName()));
    }
    
	/**
	 * @return \Zend\Http\PhpEnvironment\Request
	 */
    public function getRequest()
    {
        return $this->request;
    }

	/**
	 * @param Request $request
	 * @return \Shop\Service\Cart\Cookie
	 */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

	/**
	 * @return \Shop\Service\Cart\Reponse
	 */
    public function getResponse()
    {
        return $this->response;
    }

	/**
	 * @param Response $response
	 * @return \Shop\Service\Cart\Cookie
	 */
    public function setResponse(Response $response)
    {
        $this->response = $response;
        return $this;
    }

	/**
	 * @return \Shop\Options\CartCookieOptions
	 */
    public function getCookieConfig()
    {
        return $this->cookieConfig;
    }

	/**
	 * @param CartCookieOptions $cookieConfig
	 * @return \Shop\Service\Cart\Cookie
	 */
    public function setCookieConfig(CartCookieOptions $cookieConfig)
    {
        $this->cookieConfig = $cookieConfig;
        return $this;
    }
}
