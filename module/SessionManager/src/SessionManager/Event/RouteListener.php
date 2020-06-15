<?php

namespace SessionManager\Event;

use SessionManager\Service\Factory\SessionManagerFactory;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Session\SessionManager;

class RouteListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    /**
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_ROUTE,
            [$this, 'startSession'],
            1
        );
    }

    /**
     * @param MvcEvent $mvcEvent
     */
    public function startSession(MvcEvent $mvcEvent)
    {
        if (!$mvcEvent->getRequest() instanceof Request) {
            return;
        }

        /* @var SessionManager $session */
        $session = $mvcEvent->getApplication()
            ->getServiceManager()
            ->get(SessionManagerFactory::class);

        if (!$session->isValid()) $session->destroy();

        $session->start();
    }
}