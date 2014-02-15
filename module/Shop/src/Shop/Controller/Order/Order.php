<?php
namespace Shop\Controller\Order;

use Application\Controller\AbstractCrudController;

class Order extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'orderNumber');
	protected $serviceName = 'Shop\Service\Order';
	protected $route = 'admin/shop/order';
	
	public function cancelOrderAction()
	{
	    // cancel order.
	}
}
