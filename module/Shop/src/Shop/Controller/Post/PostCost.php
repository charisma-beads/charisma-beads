<?php
namespace Shop\Controller\Post;

use UthandoCommon\Controller\AbstractCrudController;

class PostCost extends AbstractCrudController
{
	protected $controllerSearchOverrides = array('sort' => 'cost');
	protected $serviceName = 'ShopPostCost';
	protected $route = 'admin/shop/post/cost';
}
