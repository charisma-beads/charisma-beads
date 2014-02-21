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
	
	public function myOrdersAction()
	{
	    $userId = $this->identity()->getUserId();
	    $page = $this->params()->fromRoute('page', 1);
	    
	    /* @var $service \Shop\Service\Order */
	    $service = $this->getService()->usePaginator(array(
			'limit'	=> 6,
			'page'	=> $page
		));
	    
	    $orders = $service->getCustomerOrdersByUserId($userId);
	    
	    return array(
	    	'orders' => $orders,
	    );
	}
	
	public function viewAction()
	{
	    // make sure we only get order for the logged in user
	    $id = $this->params()->fromRoute('orderId', 0);
	    $userId = $this->identity()->getUserId();
	    
        /* @var $service \Shop\Service\Order */
	    $service = $this->getService();
	    $order = $service->getCustomerOrderByUserId($id, $userId);
	    
	    // if order returns false then return to my-order
	    if (false === $order) {
	        return $this->redirect()->toRoute('shop/order');
	    }
	    
	    return array(
	    	'order' => $order,
	    );
	}
}
