<?php
namespace Shop\Controller;

use Application\Controller\AbstractCrudController;

class PostCostController extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'cost');
	protected $serviceName = 'Shop\Service\PostCost';
	protected $route = 'admin/shop/post/cost';
}
