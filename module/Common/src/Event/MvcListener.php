<?php

namespace Common\Event;

use Common\Options\GeneralOptions;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\EventManager\ListenerAggregateTrait;
use Laminas\Http\Request;
use Laminas\Http\Response;
use Laminas\Mvc\Application as MvcApplication;
use Laminas\Mvc\Controller\AbstractController;
use Laminas\Mvc\MvcEvent;
use Laminas\Uri\Http as HttpUri;


class MvcListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    /**
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, [$this, 'requireSsl'], -10000);
        $this->listeners[] = $events->getSharedManager()
            ->attach(AbstractController::class,MvcEvent::EVENT_DISPATCH, [$this, 'maintenanceMode'], 100);
    }

    public function maintenanceMode(MvcEvent $e): bool
    {
        $routeMatch = $e->getRouteMatch();
        $controller = $e->getTarget();
        $options    = $e->getApplication()->getServiceManager()->get(GeneralOptions::class);

        if (!$routeMatch->getParam('is-admin') && $options->isMaintenanceMode()) {
            $controller->layout('layout/maintenance');
            $e->stopPropagation();
        }

        return true;
    }

    /**
     * @param MvcEvent $event
     * @return mixed
     */
    public function requireSsl(MvcEvent $event)
    {
        $request        = $event->getRequest();

        if (!$request instanceof Request) {
            return true;
        }

        $application    = $event->getApplication();
        $options        = $application->getServiceManager()->get(GeneralOptions::class);
        $response       = $event->getResponse();
        $uri            = $request->getUri();

        if (false === $options->isSsl()) {
            return true;
        }

        if ($event->isError() && $event->getError() === MvcApplication::ERROR_ROUTER_NO_MATCH) {
            // No matched route has been found - don't do anything
            return true;
        }

        // only redirect to SSL if on HTTP
        if ('http' === $uri->getScheme()) {
            $uri->setScheme('https');
            return self::redirect($uri, $response);
        }

        return true;
    }

    private function redirect(HttpUri $uri, Response $response): Response
    {
        $response->getHeaders()->addHeaderLine('Location', $uri->toString());
        $response->setStatusCode(302);

        return $response;
    }
}
