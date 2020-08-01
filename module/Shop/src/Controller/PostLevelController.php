<?php

namespace Shop\Controller;

use Shop\Service\PostLevelService;
use Common\Controller\AbstractCrudController;

/**
 * Class PostLevel
 *
 * @package Shop\Controller
 */
class PostLevelController extends AbstractCrudController
{
	protected $controllerSearchOverrides = ['sort' => 'postLevel'];
	protected $serviceName = PostLevelService::class;
	protected $route = 'admin/shop/post/level';
}
