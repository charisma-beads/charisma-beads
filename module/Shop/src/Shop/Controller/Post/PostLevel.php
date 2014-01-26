<?php
namespace Shop\Controller\Post;

use Application\Controller\AbstractCrudController;

class PostLevel extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'postLevel');
	protected $serviceName = 'Shop\Service\PostLevel';
	protected $route = 'admin/shop/post/level';
}
