<?php

namespace Navigation\Event;

use Navigation\Service\SiteMapService;
use Laminas\EventManager\Event;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateTrait;
use Laminas\Navigation\Navigation;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;


abstract class AbstractSiteMapListener implements SiteMapListenerInterface, ServiceLocatorAwareInterface
{
    /**
     * @var array
     */
    protected $pages = [];

    /**
     * @var Event
     */
    protected $event;

    use ListenerAggregateTrait,
        ServiceLocatorAwareTrait;

    /**
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        $events = $events->getSharedManager();

        $this->listeners[] = $events->attach([
            SiteMapService::class,
        ], ['uthando.site-map'], [$this, 'addPages']);
    }

    /**
     * @param Event $e
     */
    public function addPages(Event $e)
    {
        $this->event = $e;
        $pages = $this->getPages();

        // find parent page
        $parentPage = $this->getNavigation()
            ->findOneByRoute($this->getRoute());

        // add pages to parent
        $parentPage->addPages($e->getTarget()->preparePages($pages));
    }

    /**
     * @return array
     */
    abstract function getPages() : array;

    /**
     * @return string
     */
    abstract function getRoute() : string;

    /**
     * @return Navigation
     */
    public function getNavigation() : Navigation
    {
        return $this->event->getParam('navigation');
    }
}
