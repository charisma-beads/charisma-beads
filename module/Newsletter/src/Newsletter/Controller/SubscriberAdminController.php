<?php

namespace Newsletter\Controller;

use Common\Controller\AbstractCrudController;
use Newsletter\Service\SubscriberService;


class SubscriberAdminController extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'subscriberId'];
    protected $serviceName = SubscriberService::class;
    protected $route = 'admin/newsletter/subscriber';

    public function editAction()
    {
        $id = (int) $this->params('id', 0);
        $this->getService()->setFormOptions([
            'subscriber_id' => $id,
        ]);

        return parent::editAction();
    }
}
