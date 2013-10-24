<?php

namespace User\Controller;

use Application\Controller\AbstractController;
use User\Form\User as UserForm;
use Zend\View\Model\ViewModel;

class UserController extends AbstractController
{
	/**
	 * @var \User\Service\User
	 */
	protected $userService;
	
	public function thankYouAction()
	{
		return new ViewModel();
	}
	
	public function registerAction()
	{
        $request = $this->getRequest();
        
        if ($request->isPost()) {
        	
        	$post = $request->getPost();
        	$post['role'] = 'registered'; 
        
        	$result = $this->getUserService()->add($post);
        
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
        			
        			// log user in
        			$this->getServiceLocator()
        			     ->get('Zend\Authentication\AuthenticationService')
        			     ->authenticate($post);
        			
        			$return = ($post['returnTo']) ? $post['returnTo'] : 'user/thank-you';
        			
        			return $this->redirect()->toRoute($return);
        			
        		} else {
        			$this->flashMessenger()->addErrorMessage(
        				'We could not register you due to a database error. Please try again later.'
        			);
        		}
        	}
        }
        
        return new ViewModel(array(
        	'form' => $this->getUserService()->getForm(),
        ));
	}

	public function editAction()
	{
		$user = $this->identity();

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
						'Your changes have been saved.'
					);
					
					// Redirect to user
					return $this->redirect()->toRoute('user');
					
				} else {
					$this->flashMessenger()->addErrorMessage(
						'We could not save your cahnges due to a database error.'
					);
				}
			}
		}
		
		$form = $this->getUserService()->getForm($user);
		
		return new ViewModel(array(
			'form' => $form
		));
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

