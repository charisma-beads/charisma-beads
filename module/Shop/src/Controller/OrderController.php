<?php

namespace Shop\Controller;

use Shop\Form\Element\OrderStatusList;
use Shop\Options\ReportsOptions;
use Shop\Service\OrderService;
use Common\Controller\AbstractCrudController;
use ShopDomPdf\View\Model\PdfModel;
use Shop\ShopException;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;

/**
 * Class Order
 *
 * @package Shop\Controller
 * @method OrderService getService()
 */
class OrderController extends AbstractCrudController
{
	protected $controllerSearchOverrides = ['sort' => '-orderDate'];
	protected $serviceName = OrderService::class;
	protected $route = 'admin/shop/order';

    public function addAction()
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
            throw new ShopException('Action not allowed');
        }

        return parent::addAction();
    }

    public function currentOrdersAction()
    {
        $request = $this->getRequest();

        if ($request->isXmlHttpRequest()) {
            $viewModel = $this->getCurrentOrders();
            return $viewModel;
        }

        throw new ShopException('Not Allowed');
    }

    public function monthlyTotalsAction()
    {
        $start = $this->params()->fromPost('start', null);
        $end = $this->params()->fromPost('end', null);

        /** @var \Shop\Options\ReportsOptions $options */
        $options = $this->getService(ReportsOptions::class);

        $data = $this->getService()
            ->getMonthlyTotals($start, $end, $options->getMonthFormat());

        $viewModel = new ViewModel([
            'monthlyTotals' => $data,
        ]);

        $viewModel->setTerminal(true);

        return $viewModel;
    }

    public function orderListAction()
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
            return $this->redirect()->toRoute($this->getRoute(), $this->params()->fromRoute());
        }

        $customerId = $this->params()->fromPost('customerId');

        /* @var $service OrderService */
        $service = $this->getService();
        $models = $service->getCustomerOrdersByCustomerId($customerId);

        $viewModel = new ViewModel([
            'models' => $models
        ]);
        $viewModel->setTerminal(true);

        return $viewModel;

    }

    public function updateStatusAction()
    {
        $request = $this->getRequest();

        if ($request->isXmlHttpRequest() && $request->isPost()) {
            /* @var $service OrderService */
            $service = $this->getService();

            $result = $service->updateOrderStatus(
                $this->params()->fromPost('orderNumber', null),
                $this->params()->fromPost('orderStatusId', null)
            );

            $jsonModel = new JsonModel();

            if ($result) {
                $viewRenderer = $this->getService('ViewRenderer');
                return $jsonModel->setVariables([
                    'html' => $viewRenderer->render($this->getCurrentOrders()),
                    'success' => true
                ]);
            } else {
                return $jsonModel->setVariable('success', false);
            }
        }

        throw new ShopException('Not Allowed');
    }
	
	public function cancelOrderAction()
	{
	    // cancel order.
	}
	
	public function myOrdersAction()
	{
	    $userId = $this->identity()->getUserId();
	    $page = $this->params()->fromRoute('page', 1);
	    
	    /* @var $service OrderService */
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

        // if order returns false then return to my-order
        if (false === $order) {
            return $this->redirect()->toRoute('shop/order');
        }
	    
	    return ['order' => $order];
	}
	
	public function printAction()
	{
	    $order = $this->getCustomerOrder();

        // if order returns false then return to my-order
        if (false === $order) {
            return $this->redirect()->toRoute('shop/order');
        }

        /* @var PdfModel $pdf */
	    $pdf = $this->getService(PdfModel::class);

        $pdf->setVariable('order', $order);

	    $pdf->setTerminal(true);
	    
	    return $pdf;
	}

    private function getCurrentOrders()
    {
        $formElement = $this->getServiceLocator()
            ->get('FormElementManager')
            ->get(OrderStatusList::class);
        $formElement->setName('orderStatusId');

        $viewModel = new ViewModel([
            'models' => $this->getService()->getCurrentOrders(),
            'statusFormElement' => $formElement,
        ]);

        $viewModel->setTerminal(true);
        $viewModel->setTemplate('shop/order/current-orders');
        return $viewModel;
    }
	
	private function getCustomerOrder()
	{
	    // make sure we only get order for the logged in user
        // if admin then allow access to all orders
	    $id = $this->params()->fromRoute('orderId', 0);
	    $userId = $this->identity()->getUserId();
	     
	    /* @var $service OrderService */
	    $service = $this->getService();

        if ($this->params()->fromRoute('is-admin', false)) {
            $id = $this->params()->fromRoute('id', 0);
            $order = $service->getById($id);
        } else {
            $order = $service->getCustomerOrderByUserId($id, $userId);
        }

        $order->rewind();

	    return $order;
	}
}
