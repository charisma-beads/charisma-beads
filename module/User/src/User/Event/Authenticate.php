<?php
namespace User\Event;

use Zend\Mvc\MvcEvent;
use Zend\Http\Request;


class Authenticate
{
    public static function checkAcl(MvcEvent $event)
    {
        if (!$event->getRequest() instanceof Request) {
    	    return;
        }
        
        $application    = $event->getApplication();
		$sm             = $application->getServiceManager();
    	$match          = $event->getRouteMatch();
    	$controller     = $match->getParam('controller');
    	$action         = $match->getParam('action');
    	$plugin         = $sm->get('ControllerPluginManager')->get('IsAllowed');
            	 
    	if (!$plugin->isAllowed($controller, $action)) {
    		$router = $event->getRouter();
    		$url    = $router->assemble(array(), array('name' => 'user/login'));
    		 
    		$response = $event->getResponse();
    		$response->setStatusCode(302);
    		//redirect to login route...
    		// change with header('location: '.$url); if code below not working 
    		$response->getHeaders()->addHeaderLine('Location', $url);
    		$event->stopPropagation();
    	}
    }
}