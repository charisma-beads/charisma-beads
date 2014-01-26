<?php
namespace Shop\Controller;

use Application\Controller\AbstractCrudController;

class Order extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'order');
	protected $serviceName = 'Shop\Service\Order';
	protected $route = 'admin/shop/order';
}
