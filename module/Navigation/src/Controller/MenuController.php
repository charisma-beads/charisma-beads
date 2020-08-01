<?php

namespace Navigation\Controller;

use Common\Controller\AbstractCrudController;
use Navigation\Service\MenuService;


class MenuController extends AbstractCrudController
{
	protected $controllerSearchOverrides = array('sort' => 'menu');
	protected $serviceName = MenuService::class;
	protected $route = 'admin/menu';
	
}
