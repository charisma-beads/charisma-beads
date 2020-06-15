<?php

namespace Navigation\Event;

use Zend\EventManager\Event;
use Zend\Navigation\Navigation;


interface SiteMapListenerInterface
{
    /**
     * @param Event $e
     * @return void
     */
    public function addPages(Event $e);

    /**
     * @return array
     */
    public function getPages() : array;

    /**
     * @return string
     */
    public function getRoute() : string;

    /**
     * @return Navigation
     */
    public function getNavigation() : Navigation;
}
