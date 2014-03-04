<?php
namespace Shop\Controller\Order;

use Application\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;

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
	    
	    return ['orders' => $orders];
	}
	
	public function viewAction()
	{
	    $order = $this->getCustomerOrder();
	    
	    return ['order' => $order];
	}
	
	public function printAction()
	{
	    $order = $this->getCustomerOrder();
	    
	    $viewModel = new ViewModel(['order' => $order]);
	    
	    $viewModel->setTerminal(true);
	    
	    return $viewModel;
	}
	
	private function getCustomerOrder()
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
	    
	    return $order;
	}
}
