<?php
namespace Shop\Controller\Post;

use UthandoCommon\Controller\AbstractCrudController;

class PostCost extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'cost');
	protected $serviceName = 'Shop\Service\Post\Cost';
	protected $route = 'admin/shop/post/cost';
}
