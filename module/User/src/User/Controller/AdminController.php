<?php

namespace User\Controller;

use Application\Controller\AbstractController;
use User\Form\User as UserForm;
use User\UserException;
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
		if (!$this->isAllowed('UserAdmin', 'view')) {
			return $this->redirect()->toRoute('home');
		}
		
		$page = $this->params()->fromRoute('page');
		
		$params = array(
			'sort' => 'lastname',
			'count' => 25,
			'page' => ($page) ? $page : 1
		);
		
		return new ViewModel(array(
			'users' => $this->getUserService()->fetchAllUsers($params),
			//'searchForm' => new UserSearch()
		));
	}
	
	public function listAction()
	{
		if (!$this->isAllowed('UserAdmin', 'view')) {
			throw new UserException('Access Denied');
		}
	
		$params = $this->params()->fromPost();
		
		$viewModel = new ViewModel(array(
			'users' => $this->getUserService()->fetchAllUsers($params)
		));
	
		$viewModel->setTerminal(true);
		return $viewModel;
	}
	
	
	public function addAction()
	{
		if (!$this->isAllowed('UserAdmin', 'add')) {
			return $this->redirect()->toRoute('home');
		}

		$request = $this->getRequest();

		if ($request->isPost()) {

			$result = $this->getUserService()->addUser($request->getPost());
				
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
			'form' => $this->getUserService()->getUserForm(),
		));
	}
	
	public function editAction()
	{
		if (!$this->isAllowed('UserAdmin', 'edit')) {
			return $this->redirect()->toRoute('home');
		}

		$id = (int) $this->params('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('admin/user', array(
				'action' => 'add'
			));
		}

		// Get the User with the specified id.  An exception is thrown
		// if it cannot be found, in which case go to the list page.
		try {
			$user = $this->getUserService()->getUserById($id);
		} catch (\Exception $e) {
			return $this->redirect()->toRoute('admin/user', array(
				'action' => 'list'
			));
		}

		$request = $this->getRequest();
		if ($request->isPost()) {
				
			$result = $this->getUserService()->editUser($user, $request->getPost());
				
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
		
		$form = $this->getUserService()->getUserForm($user);
		
		return new ViewModel(array(
			'form' => $form,
			'user' => $user
		));
	}
	
	public function deleteAction()
	{
		if (!$this->isAllowed('UserAdmin', 'delete')) {
			return $this->redirect()->toRoute('home');
		}

		$request = $this->getRequest();

		$id = (int) $request->getPost('userId');
		if (!$id) {
			return $this->redirect()->toRoute('admin/user');
		}

		if ($request->isPost()) {
			$del = $request->getPost('submit', 'No');

			if ($del == 'delete') {
				$id = (int) $request->getPost('userId');
				$result = $this->getUserService()->deleteUser($id);

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
