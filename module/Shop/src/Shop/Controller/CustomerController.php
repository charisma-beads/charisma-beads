<?php
namespace Shop\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class CustomerController extends AbstractController
{
	/**
	 * @var \Shop\Service\Customer
	 */
	protected $customerService;
	
	public function indexAction()
	{
		$page = $this->params()->fromRoute('page', 1);
		 
		$params = array(
			'sort' => 'name',
		);
		 
		return new ViewModel(array(
			'customers' => $this->getCustomerService()->usePaginator(array(
				'limit' => 25,
				'page' => $page
			))->searchCustomers($params)
		));
	}
	
	public function listAction()
	{
		if (!$this->getRequest()->isXmlHttpRequest()) {
			return $this->redirect()->toRoute('admin/shop/customer');
		}
		 
		$params = $this->params()->fromPost();
		 
		$viewModel = new ViewModel(array(
			'customers' => $this->getCustomerService()->usePaginator(array(
				'limit' => $params['count'],
				'page' => $params['page']
			))->searchCustomers($params)
		));
		 
		$viewModel->setTerminal(true);
		 
		return $viewModel;
	}
	
	/**
	 * @return \Shop\Service\Customer
	 */
	protected function getCustomerService()
	{
		if (null === $this->customerService) {
			$sl = $this->getServiceLocator();
			$this->customerService = $sl->get('Shop\Service\Customer');
		}
	
		return $this->customerService;
	}
}
