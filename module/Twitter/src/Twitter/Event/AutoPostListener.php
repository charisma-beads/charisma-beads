<?php

namespace Twitter\Event;

use Common\Service\AbstractService;
use Twitter\Service\Twitter;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;

class AutoPostListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    const EVENT_TWITTER_STATUS = 'update.twitter.status';

    /**
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        $events = $events->getSharedManager();

        $this->listeners[] = $events->attach(
            AbstractService::class,
            self::EVENT_TWITTER_STATUS,
            [$this, 'twitterStatusUpdate']
        );
    }

    public function twitterStatusUpdate(Event $e)
    {
        /* @var Twitter $twitter */
        $twitter = $e->getTarget()->getService(Twitter::class);
        $status = $e->getParam('string');

        $response = $twitter->statusUpdate($status);

        $e->setParam('response', $response);

    }
}