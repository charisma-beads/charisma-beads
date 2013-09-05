<?php

namespace User\Controller;

use Application\Controller\AbstractController;
use User\Form\UserForm;
use Zend\View\Model\ViewModel;

class UserController extends AbstractController
{
	public function thankYouAction()
	{
		return new ViewModel();
	}
	
	public function registerAction()
	{
		if (!$this->isAllowed('Guest')) {
            return $this->redirect()->toRoute('home');
        }
        
        $request = $this->getRequest();
        
        if ($request->isPost()) {
        	
        	$post = $request->getPost();
        	$post['role'] = 'registered'; 
        
        	$result = $this->getModel('User\Model\User')->addUser($post);
        
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
        				'Thank you, you have successfully registered with us.'
        			);
        			
        			// Redirect to home
        			return $this->redirect()->toRoute('user/thank-you');
        			
        		} else {
        			$this->flashMessenger()->addErrorMessage(
        				'We could not register you due to a database error. Please try again later.'
        			);
        		}
        	}
        }
        
        return new ViewModel(array(
        	'form' => $this->getModel('User\Model\User')->getForm('user'),
        ));
	}

	public function editAction()
	{
		if (!$this->isAllowed('User', 'edit')) {
			return $this->redirect()->toRoute('home');
		}
		
		$user = $this->identity();

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
						'Your changes have been saved.'
					);
					
					// Redirect to user
					return $this->redirect()->toRoute('user/edit');
					
				} else {
					$this->flashMessenger()->addErrorMessage(
						'We could not save your cahnges due to a database error.'
					);
				}
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

