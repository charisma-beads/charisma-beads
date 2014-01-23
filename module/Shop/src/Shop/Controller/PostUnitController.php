<?php
namespace Shop\Controller;

use Application\Controller\AbstractCrudController;

class PostUnitController extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'postUnit');
	protected $serviceName = 'Shop\Service\PostUnit';
	protected $route = 'admin/shop/post/unit';
}
