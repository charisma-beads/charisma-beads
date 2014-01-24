<?php

namespace User\Controller;

use Application\Controller\AbstractCrudController;

class AdminController extends AbstractCrudController
{
    protected $searchDefaultParams = array('sort' => 'lastname');
    protected $serviceName = 'User\Service\User';
    protected $route = 'admin/user';
}
