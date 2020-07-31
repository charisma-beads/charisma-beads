<?php

namespace Common\Event;

use Common\Service\AbstractService;
use Laminas\EventManager\Event;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\EventManager\ListenerAggregateTrait;


class ServiceListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    /**
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        $events = $events->getSharedManager();

        $this->listeners[] = $events->attach(
            AbstractService::class,
            'pre.edit',
            [$this, 'edit']
        );
    }

    /**
     * @param Event $e
     */
    public function edit(Event $e)
    {
        /* @var $model \Common\Model\ModelInterface */
        $model = $e->getParam('model');

        if ($model->has('dateModified')) {
            $model->setDateModified();
        }

    }
}
