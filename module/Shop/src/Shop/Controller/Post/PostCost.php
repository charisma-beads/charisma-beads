<?php
namespace Shop\Controller\Post;

use Application\Controller\AbstractCrudController;

class PostCost extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'cost');
	protected $serviceName = 'Shop\Service\PostCost';
	protected $route = 'admin/shop/post/cost';
}
