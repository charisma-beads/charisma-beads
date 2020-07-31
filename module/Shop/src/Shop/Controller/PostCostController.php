<?php

namespace Shop\Controller;

use Shop\Service\PostCostService;
use Common\Controller\AbstractCrudController;

/**
 * Class PostCost
 *
 * @package Shop\Controller
 */
class PostCostController extends AbstractCrudController
{
	protected $controllerSearchOverrides = array('sort' => 'cost');
	protected $serviceName = PostCostService::class;
	protected $route = 'admin/shop/post/cost';
}
