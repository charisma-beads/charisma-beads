<?php

declare(strict_types=1);

namespace User\Controller;

use Common\Controller\AbstractCrudController;
use User\Service\LimitLoginService;

class LimitLoginController extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'id'];
    protected $serviceName = LimitLoginService::class;
    protected $route = 'admin/user/limit-login';
}
