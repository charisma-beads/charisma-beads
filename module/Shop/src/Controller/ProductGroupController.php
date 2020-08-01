<?php

namespace Shop\Controller;

use Shop\Service\ProductGroupService;
use Common\Controller\AbstractCrudController;

/**
 * Class ProductGroup
 *
 * @package Shop\Controller
 */
class ProductGroupController extends AbstractCrudController
{
	protected $controllerSearchOverrides = array('sort' => 'productGroupId');
	protected $serviceName = ProductGroupService::class;
	protected $route = 'admin/shop/group';
	
}
