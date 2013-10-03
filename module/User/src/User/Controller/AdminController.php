<?php

namespace User\Controller;

use Application\Controller\AbstractController;
use User\Form\User as UserForm;
use Zend\View\Model\ViewModel;
use FB;

class AdminController extends AbstractController
{
	/**
	 * @var \User\Service\User
	 */
	protected $userService;
	
	public function indexAction()
	{
		$page = $this->params()->fromRoute('page');
		
		$params = array(
			'sort' => 'lastname',
			'count' => 25,
			'page' => ($page) ? $page : 1
		);
		
		return new ViewModel(array(
			'users' => $this->getUserService()->fetchAllUsers($params)
		));
	}
	
	public function listAction()
	{
		$params = $this->params()->fromPost();
		
		$viewModel = new ViewModel(array(
			'users' => $this->getUserService()->fetchAllUsers($params)
		));
	
		$viewModel->setTerminal(true);
		return $viewModel;
	}
	
	
	public function addAction()
	{
		$request = $this->getRequest();

		if ($request->isPost()) {

			$result = $this->getUserService()->add($request->getPost());
				
			if ($result instanceof UserForm) {

				$this->flashMessenger()->addInfoMessage(
					'There were one or more isues with your submission. Please correct them as indicated below.'
				);

				return new ViewModel(array(
					'form' => $result
				));

			} else {
				if ($result) {
					$this->flashMessenger()->addSuccessMessage(
						'User has been saved to database.'
					);
				} else {
					$this->flashMessenger()->addErrorMessage(
						'User could not be saved due to a database error.'
					);
				}

				// Redirect to list of articles
				return $this->redirect()->toRoute('admin/user');
			}
		}

		return new ViewModel(array(
			'form' => $this->getUserService()->getForm(),
		));
	}
	
	public function editAction()
	{
		$id = (int) $this->params('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('admin/user', array(
				'action' => 'add'
			));
		}

		// Get the User with the specified id.  An exception is thrown
		// if it cannot be found, in which case go to the list page.
		try {
			$user = $this->getUserService()->getById($id);
		} catch (\Exception $e) {
			return $this->redirect()->toRoute('admin/user', array(
				'action' => 'list'
			));
		}

		$request = $this->getRequest();
		if ($request->isPost()) {
				
			$result = $this->getUserService()->edit($user, $request->getPost());
				
			if ($result instanceof UserForm) {

				$this->flashMessenger()->addInfoMessage(
					'There were one or more isues with your submission. Please correct them as indicated below.'
				);

				return new ViewModel(array(
					'form' => $result,
					'user' => $user,
				));
			} else {
				if ($result) {
					$this->flashMessenger()->addSuccessMessage(
						'User has been saved to database.'
					);
				} else {
					$this->flashMessenger()->addErrorMessage(
						'User could not be saved due to a database error.'
					);
				}

				// Redirect to list of articles
				return $this->redirect()->toRoute('admin/user');
			}
		}
		
		$form = $this->getUserService()->getForm($user);
		
		return new ViewModel(array(
			'form' => $form,
			'user' => $user
		));
	}
	
	public function deleteAction()
	{
		$request = $this->getRequest();

		$id = (int) $request->getPost('userId');
		if (!$id) {
			return $this->redirect()->toRoute('admin/user');
		}

		if ($request->isPost()) {
			$del = $request->getPost('submit', 'No');

			if ($del == 'delete') {
				$id = (int) $request->getPost('userId');
				$result = $this->getUserService()->delete($id);

				if ($result) {
					$this->flashMessenger()->addSuccessMessage(
						'User has been deleted from the database.'
					);
				} else {
					$this->flashMessenger()->addErrorMessage(
						'User could not be deleted due to a database error.'
					);
				}
			}

			// Redirect to list of users
			return $this->redirect()->toRoute('admin/user');
		}

		return $this->redirect()->toRoute('admin/user');
	}
	
	/**
	 * @return \User\Service\User
	 */
	protected function getUserService()
	{
		if (!$this->userService) {
			$sl = $this->getServiceLocator();
			$this->userService = $sl->get('User\Service\User');
		}
	
		return $this->userService;
	}
}
