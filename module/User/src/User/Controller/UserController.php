<?php

namespace User\Controller;

use Application\Controller\AbstractController;
use User\Form\UserForm;
use Zend\View\Model\ViewModel;

class UserController extends AbstractController
{
	public function registerAction()
	{
		if (!$this->isAllowed('Guest')) {
            return $this->redirect()->toRoute('home');
        }
	}

	public function editAction()
	{
		if (!$this->isAllowed('User', 'edit')) {
			return $this->redirect()->toRoute('home');
		}

		
		// lock the user into only editing his propile by extracting value
		// from seesion auth values.
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('user', array(
				'action' => 'edit'
			));
		}

		// Get the User with the specified id.  An exception is thrown
		// if it cannot be found, in which case go to the list page.
		try {
			$user = $this->getModel('User\Model\User')->getUserById($id);
		} catch (\Exception $e) {
			return $this->redirect()->toRoute('user', array(
				'action' => 'index'
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
}

