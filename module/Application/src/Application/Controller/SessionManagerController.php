<?php
namespace Application\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Exception;

class SessionManagerController extends AbstractController
{
	public function indexAction()
	{
		if (!$this->isAllowed('SessionManager', 'view')) {
			return $this->redirect()->toRoute('home');
		}
		
		$page = $this->params()->fromRoute('page');
		
		$params = array(
			'sort' => 'id',
			'count' => 25,
			'page' => ($page) ? $page : 1
		);
		
		return new ViewModel(array(
			'sessions' => $this->getModel('Application\Model\SessionManager')->fetchAllSessions($params),
		));
	}
	
	public function viewAction()
	{
		if (!$this->isAllowed('SessionManager', 'view')) {
			throw new Exception('Access Denied');
		}
	
		$id = (string) $this->params()->fromRoute('id', 0);
	
		$viewModel = new ViewModel(array(
			'session' => $this->getModel('Application\Model\SessionManager')->getSessionById($id)
		));
	
		$viewModel->setTerminal(true);
		return $viewModel;
	}
	
	public function listAction()
	{
		if (!$this->isAllowed('SessionManager', 'view')) {
			throw new Exception('Access Denied');
		}
	
		$params = $this->params()->fromPost();
		
		$viewModel = new ViewModel(array(
			'sessions' => $this->getModel('Application\Model\SessionManager')->fetchAllSessions($params)
		));
	
		$viewModel->setTerminal(true);
		return $viewModel;
	}
	
	public function deleteAction()
	{
		if (!$this->isAllowed('SessionManager', 'delete')) {
			return $this->redirect()->toRoute('home');
		}
	
		$request = $this->getRequest();
	
		$id = (string) $request->getPost('id');
		if (!$id) {
			return $this->redirect()->toRoute('admin/session');
		}
	
		if ($request->isPost()) {
			$del = $request->getPost('submit', 'No');
	
			if ($del == 'delete') {
				$result = $this->getModel('Application\Model\SessionManager')->deleteSession($id);
	
				if ($result) {
					$this->flashMessenger()->addSuccessMessage(
						'Session has been deleted from the database.'
					);
				} else {
					$this->flashMessenger()->addErrorMessage(
						'Session could not be deleted due to a database error.'
					);
				}
			}
	
			// Redirect to list of users
			return $this->redirect()->toRoute('admin/session');
		}
	
		return $this->redirect()->toRoute('admin/session');
	}

}