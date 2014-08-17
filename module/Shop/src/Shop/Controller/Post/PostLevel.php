<?php
namespace Shop\Controller\Post;

use UthandoCommon\Controller\AbstractCrudController;

class PostLevel extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'postLevel');
	protected $serviceName = 'Shop\Service\Post\Level';
	protected $route = 'admin/shop/post/level';
}
