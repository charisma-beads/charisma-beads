<?php
namespace Shop\Controller;

use Application\Controller\AbstractCrudController;

class OrderController extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'order');
	protected $serviceName = 'Shop\Service\Order';
	protected $route = 'admin/shop/order';
}
