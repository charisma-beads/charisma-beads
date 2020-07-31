<?php

namespace Shop\Service;

use Shop\Options\CartCookieOptions;
use Laminas\Http\Header\SetCookie;
use Laminas\Http\PhpEnvironment\Request;
use Laminas\Http\PhpEnvironment\Response;

/**
 * Class Cookie
 *
 * @package Shop\Service
 */
class CartCookieService
{
    /**
     * @var Request
     */
    protected $request;
    
    /**
     * @var Response
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
	 * @return \Laminas\Http\PhpEnvironment\Request
	 */
    public function getRequest()
    {
        return $this->request;
    }

	/**
	 * @param Request $request
	 * @return \Shop\Service\CartCookieService
	 */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

	/**
	 * @param Response $response
	 * @return \Shop\Service\CartCookieService
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
	 * @return \Shop\Service\CartCookieService
	 */
    public function setCookieConfig(CartCookieOptions $cookieConfig)
    {
        $this->cookieConfig = $cookieConfig;
        return $this;
    }
}
