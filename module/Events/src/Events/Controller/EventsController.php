<?php

namespace Events\Controller;

use Common\Controller\AbstractCrudController;
use Events\ServiceManager\EventsService;


class EventsController extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'eventId'];
    protected $serviceName = EventsService::class;
    protected $route = 'admin/events';
}
