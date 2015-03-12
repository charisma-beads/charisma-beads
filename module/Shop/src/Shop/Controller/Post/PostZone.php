<?php
namespace Shop\Controller\Post;

use UthandoCommon\Controller\AbstractCrudController;

class PostZone extends AbstractCrudController
{
	protected $controllerSearchOverrides = array('sort' => 'zone');
	protected $serviceName = 'ShopPostZone';
	protected $route = 'admin/shop/post/zone';
}
