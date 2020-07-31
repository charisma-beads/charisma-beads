<?php

namespace Shop\Controller;

use Shop\Service\PostZoneService;
use Common\Controller\AbstractCrudController;

/**
 * Class PostZone
 *
 * @package Shop\Controller
 */
class PostZoneController extends AbstractCrudController
{
	protected $controllerSearchOverrides = array('sort' => 'zone');
	protected $serviceName = PostZoneService::class;
	protected $route = 'admin/shop/post/zone';
}
