<?php
namespace Shop\Controller;

use Application\Controller\AbstractCrudController;

class PostZoneController extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'zone');
	protected $serviceName = 'Shop\Service\PostZone';
	protected $route = 'admin/shop/post/zone';
}
