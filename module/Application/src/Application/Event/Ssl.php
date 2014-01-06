<?php
namespace Application\Event;

use Zend\Mvc\MvcEvent;
use Zend\Http\Request;

class Ssl
{
    public static function checkSsl(MvcEvent $event)
    {
        $request = $event->getRequest();
        
        if (!$request instanceof Request) {
        	return;
        }
        
        if ($event->isError() && $event->getError() === Application::ERROR_ROUTER_NO_MATCH) {
        	// No matched route has been found - don't do anything
        	return;
        }
    
    	$match          = $event->getRouteMatch();
    	$params         = $match->getParams();
    	
    	/**
    	 * If we have a route tht defines 'force-ssl' prefer that instruction above
    	 * anything else and redirect if appropriate
    	 *
    	 * Possible values of 'force-ssl' param are:
    	 *   'ssl' : Force SSL
    	 *   'http'     : Force Non-SSL
    	 */
    	if (isset($params['force-ssl'])) {
    		$force    = strtolower($params['force-ssl']);
    		$response = $event->getResponse();
    		$uri      = $request->getUri();
    		
    		if ('ssl' === $force && 'http' === $uri->getScheme()) {
    		    $uri->setScheme('https');
    		    return self::redirect($uri, $response);
    		}
    		
    		if ('http' === $force && 'https' === $uri->getScheme()) {
    			$uri->setScheme('http');
    			return self::redirect($uri, $response);
    		}
    	}
    	
    	return;
    }
    
    public static function redirect($uri, $response)
    {
        $response->getHeaders()->addHeaderLine('Location', $uri->toString());
        $response->setStatusCode(302);
         
        return $response;
    }
}
