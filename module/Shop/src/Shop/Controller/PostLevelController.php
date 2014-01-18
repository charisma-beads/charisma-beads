<?php
namespace Shop\Controller;

use Application\Controller\AbstractCrudController;

class PostLevelController extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'postLevel');
	protected $serviceName = 'Shop\Service\PostLevel';
	protected $route = 'admin/shop/post/level';
}
