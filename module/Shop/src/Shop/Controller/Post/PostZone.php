<?php
namespace Shop\Controller\Post;

use Application\Controller\AbstractCrudController;

class PostZone extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'zone');
	protected $serviceName = 'Shop\Service\PostZone';
	protected $route = 'admin/shop/post/zone';
}
