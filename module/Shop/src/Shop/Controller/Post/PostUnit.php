<?php
namespace Shop\Controller\Post;

use UthandoCommon\Controller\AbstractCrudController;

class PostUnit extends AbstractCrudController
{
	protected $controllerSearchOverrides = array('sort' => 'postUnit');
	protected $serviceName = 'ShopPostUnit';
	protected $route = 'admin/shop/post/unit';
}
