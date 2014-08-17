<?php
namespace Shop\Controller\Post;

use UthandoCommon\Controller\AbstractCrudController;

class PostZone extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'zone');
	protected $serviceName = 'Shop\Service\Post\Zone';
	protected $route = 'admin/shop/post/zone';
}
