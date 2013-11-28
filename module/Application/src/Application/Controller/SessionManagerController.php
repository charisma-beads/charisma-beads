<?php
namespace Application\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Exception;

class SessionManagerController extends AbstractController
{
	/**
	 * @var \Application\Service\SessionManager
	 */
	protected $sessionService;
	
	public function indexAction()
	{
		$page = $this->params()->fromRoute('page');
		
		$params = array(
			'sort' => 'id',
			'count' => 25,
			'page' => ($page) ? $page : 1
		);
		
		return new ViewModel(array(
			'sessions' => $this->getSessionService()->fetchAllSessions($params),
		));
	}
	
	public function viewAction()
	{
		$id = (string) $this->params()->fromRoute('id', 0);
	
		$viewModel = new ViewModel(array(
			'session' => $this->getSessionService()->getSessionById($id)
		));
	
		$viewModel->setTerminal(true);
		return $viewModel;
	}
	
	public function listAction()
	{
	    if (!$this->getRequest()->isXmlHttpRequest()) {
	    	return $this->redirect()->toRoute('admin/session');
	    }
	    
		$params = $this->params()->fromPost();
		
		$viewModel = new ViewModel(array(
			'sessions' => $this->getSessionService()->fetchAllSessions($params)
		));
	
		$viewModel->setTerminal(true);
		return $viewModel;
	}
	
	public function deleteAction()
	{
		$request = $this->getRequest();
	
		$id = (string) $request->getPost('id');
		if (!$id) {
			return $this->redirect()->toRoute('admin/session');
		}
	
		if ($request->isPost()) {
			$del = $request->getPost('submit', 'No');
	
			if ($del == 'delete') {
				$result = $this->getSessionService()->deleteSession($id);
	
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
	
	/**
	 * @return \Application\Service\SessionManager
	 */
	protected function getSessionService()
	{
		if (!$this->sessionService) {
			$sl = $this->getServiceLocator();
			$this->sessionService = $sl->get('Application\Service\SessionManager');
		}
	
		return $this->sessionService;
	}
}