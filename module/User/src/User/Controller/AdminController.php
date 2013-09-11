<?php

namespace User\Controller;

use Application\Controller\AbstractController;
use User\Form\UserForm;
use User\Model\UserException;
use Zend\View\Model\ViewModel;
use FB;

class AdminController extends AbstractController
{
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
			'users' => $this->getModel('User\Model\User')->fetchAllUsers($params),
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
			'users' => $this->getModel('User\Model\User')->fetchAllUsers($params)
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

			$result = $this->getModel('User\Model\User')->addUser($request->getPost());
				
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
			'form' => $this->getModel('User\Model\User')->getForm('user'),
		));
	}
	
	public function editAction()
	{
		if (!$this->isAllowed('UserAdmin', 'edit')) {
			return $this->redirect()->toRoute('home');
		}

		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('admin/user', array(
				'action' => 'add'
			));
		}

		// Get the User with the specified id.  An exception is thrown
		// if it cannot be found, in which case go to the list page.
		try {
			$user = $this->getModel('User\Model\User')->getUserById($id);
		} catch (\Exception $e) {
			return $this->redirect()->toRoute('admin/user', array(
				'action' => 'list'
			));
		}

		$request = $this->getRequest();
		if ($request->isPost()) {
				
			$result = $this->getModel('User\Model\User')->editUser($user, $request->getPost());
				
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
		
		$form = $this->getModel('User\Model\User')->getForm('user')->bind($user);
		$form->get('passwd')->setAttribute('value', '');
		
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
				$result = $this->getModel('User\Model\User')->deleteUser($id);

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
}