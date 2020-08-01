<?php

namespace Events\Controller;

use Common\Service\ServiceTrait;
use Events\Options\EventsOptions;
use Events\ServiceManager\EventsService;
use Laminas\Mvc\Controller\AbstractActionController;


class TimeLineController extends AbstractActionController
{
    use ServiceTrait;

    public function indexAction()
    {
        $events = $this->getService(EventsService::class)
            ->getTimeLine();

        $options = $this->getService(EventsOptions::class);

        return [
            'events' => $events,
            'options' => $options,
        ];
    }
}
