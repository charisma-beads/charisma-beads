<?php

declare(strict_types=1);

namespace User\Controller;

use Common\Controller\AbstractCrudController;
use User\Service\UserRegistrationService;

class AdminRegistrationController extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'requestTime'];
    protected $serviceName = UserRegistrationService::class;
    protected $route = 'admin/user/registration';
}
