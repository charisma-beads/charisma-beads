<?php

declare(strict_types=1);

namespace User\Event;

use User\Controller\Plugin\IsAllowed;
use User\Controller\UserController;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;

class MvcListener implements ListenerAggregateInterface
{
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = [];

    public function attach(EventManagerInterface $events)
    {
        $events = $events->getSharedManager();
        $this->listeners[] = $events->attach(
            AbstractActionController::class,
            MvcEvent::EVENT_DISPATCH,
            [$this, 'doAuthentication'],
            2
        );
    }

    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    public function doAuthentication(MvcEvent $event)
    {
        if (!$event->getRequest() instanceof Request) {
            return true;
        }

        $application    = $event->getApplication();
        $sm             = $application->getServiceManager();
        $match          = $event->getRouteMatch();
        $controller     = $match->getParam('controller');
        $action         = $match->getParam('action');
        $plugin         = $sm->get('ControllerPluginManager')->get(IsAllowed::class);
        $hasIdentity    = $plugin->getIdentity();

        if (!$plugin->isAllowed($controller, $action)) {

            $router = $event->getRouter();
            $route  = (
                'guest' === $hasIdentity->getRoleId() &&
                $plugin->isAllowed(UserController::class, 'login')
            ) ? 'user' : 'home';
            $url    = $router->assemble([], ['name' => $route]);

            $response = $event->getResponse();
            $response->setStatusCode(302);
            //redirect to login route...
            // change with header('location: '.$url); if code below not working
            $response->getHeaders()->addHeaderLine('Location', $url);
            $event->stopPropagation();
            return $response;
        }
        return true;
    }
}