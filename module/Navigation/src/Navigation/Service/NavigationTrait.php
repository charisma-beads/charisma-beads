<?php

namespace Navigation\Service;

use Laminas\Mvc\Application;
use Laminas\Mvc\Router\RouteMatch;
use Laminas\Mvc\Router\RouteStackInterface;


trait NavigationTrait
{
    /**
    * @param $pages
    * @return array
    */
    public function preparePages($pages)
    {
        /* @var  Application $application */
        $application = $this->getService('Application');
        $routeMatch  = $application->getMvcEvent()->getRouteMatch();
        $router      = $application->getMvcEvent()->getRouter();

        return $this->injectComponents($pages, $routeMatch, $router);
    }

    /**
     * @param array $pages
     * @param RouteMatch|null $routeMatch
     * @param RouteStackInterface|null $router
     * @return array
     */
    protected function injectComponents(array $pages, RouteMatch $routeMatch = null, RouteStackInterface $router = null)
    {
        foreach ($pages as &$page) {

            $hasMvc = isset($page['action']) || isset($page['controller']) || isset($page['route']);
            if ($hasMvc) {
                if (!isset($page['routeMatch']) && $routeMatch) {
                    $page['routeMatch'] = $routeMatch;
                }

                if (!isset($page['router'])) {
                    $page['router'] = $router;
                }
            }

            if (isset($page['pages'])) {
                $page['pages'] = $this->injectComponents($page['pages'], $routeMatch, $router);
            }
        }

        return $pages;
    }
}
