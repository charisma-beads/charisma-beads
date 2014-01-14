<?php
namespace Shop\Controller;

use Application\Controller\AbstractController;
use Shop\Form\Post\Zone as ZoneForm;
use Zend\View\Model\ViewModel;

class PostZoneController extends AbstractController
{
	/**
	 * @var \Shop\Service\Post\Zone
	 */
	protected $postZoneService;
	
	public function indexAction()
	{
		$page = $this->params()->fromRoute('page', 1);
			
		$params = array(
			'sort' => 'zone',
		);
			
		return new ViewModel(array(
			'zones' => $this->getPostZoneService()->usePaginator(array(
				'limit' => 25,
				'page' => $page
			))->searchZones($params)
		));
	}
	
	public function listAction()
	{
		if (!$this->getRequest()->isXmlHttpRequest()) {
			return $this->redirect()->toRoute('admin/shop/post/zone');
		}
			
		$params = $this->params()->fromPost();
			
		$viewModel = new ViewModel(array(
			'zones' => $this->getPostZoneService()->usePaginator(array(
				'limit' => $params['count'],
				'page' => $params['page']
			))->searchZones($params)
		));
			
		$viewModel->setTerminal(true);
			
		return $viewModel;
	}
	
	public function addAction()
	{
		$request = $this->getRequest();
			
		if ($request->isPost()) {
	
			$result = $this->getPostZoneService()->add($request->getPost());
	
			if ($result instanceof ZoneForm) {
					
				$this->flashMessenger()->addInfoMessage(
					'There were one or more isues with your submission. Please correct them as indicated below.'
				);
					
				return new ViewModel(array(
					'form' => $result
				));
					
			} else {
				if ($result) {
					$this->flashMessenger()->addSuccessMessage(
						'Post Zone has been saved to database.'
					);
				} else {
					$this->flashMessenger()->addErrorMessage(
						'Post Zone could not be saved due to a database error.'
					);
				}
					
				// Redirect to list of categories
				return $this->redirect()->toRoute('admin/shop/post/zone');
			}
		}
			
		return new ViewModel(array(
			'form' => $this->getPostZoneService()->getForm(),
		));
	}
	
	public function editAction()
	{
		$id = (int) $this->params('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('admin/shop/post/zone', array(
				'action' => 'add'
			));
		}
			
		// Get the Product Category with the specified id.  An exception is thrown
		// if it cannot be found, in which case go to the list page.
		try {
			$zone = $this->getPostZoneService()->getById($id);
		} catch (\Exception $e) {
			$this->setExceptionMessages($e);
			return $this->redirect()->toRoute('admin/shop/post/zone', array(
				'action' => 'list'
			));
		}
			
		$request = $this->getRequest();
			
		if ($request->isPost()) {
	
			$result = $this->getPostZoneService()->edit($zone, $request->getPost());
	
			if ($result instanceof ZoneForm) {
					
				$this->flashMessenger()->addInfoMessage(
					'There were one or more isues with your submission. Please correct them as indicated below.'
				);
					
				return new ViewModel(array(
					'form'	=> $result,
					'zone'	=> $zone,
				));
			} else {
				if ($result) {
					$this->flashMessenger()->addSuccessMessage(
						'Post Zone has been saved to database.'
					);
				} else {
					$this->flashMessenger()->addErrorMessage(
						'Post Zone could not be saved due to a database error.'
					);
				}
					
				// Redirect to list of categories
				return $this->redirect()->toRoute('admin/shop/post/zone');
			}
		}
			
		$form = $this->getPostZoneService()->getForm($zone);
			
		return new ViewModel(array(
			'form'	=> $form,
			'zone'	=> $zone,
		));
	}
	
	public function deleteAction()
	{
		$request = $this->getRequest();
			
		$id = (int) $request->getPost('postZoneId');
		if (!$id) {
			return $this->redirect()->toRoute('admin/shop/post/zone');
		}
			
		if ($request->isPost()) {
			$del = $request->getPost('submit', 'No');
	
			if ($del == 'delete') {
				try {
					$id = (int) $request->getPost('postZoneId');
					$result = $this->getPostZoneService()->delete($id);
	
					if ($result) {
						$this->flashMessenger()->addSuccessMessage(
							'Post Zone has been deleted from the database.'
						);
					} else {
						$this->flashMessenger()->addErrorMessage(
							'Post Zone could not be deleted due to a database error.'
						);
					}
				} catch (\Exception $e) {
					$this->setExceptionMessages($e);
				}
			}
	
			// Redirect to list of categories
			return $this->redirect()->toRoute('admin/shop/post/zone');
		}
			
		return $this->redirect()->toRoute('admin/shop/post/zone');
	
	}
	
	/**
	 * @return \Shop\Service\Post\Zone
	 */
	protected function getPostZoneService()
	{
		if (null === $this->postZoneService) {
			$sl = $this->getServiceLocator();
			$this->postZoneService = $sl->get('Shop\Service\PostZone');
		}
	
		return $this->postZoneService;
	}
}
