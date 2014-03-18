<?php

namespace User\Controller;

use User\Form\Login as LoginForm;
use User\Service\Authentication;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AuthController extends AbstractActionController
{   
    protected $auth;
    protected $form;
    
    public function setAuthService(Authentication $auth)
    {
    	$this->auth = $auth;
    }
    
	public function setLoginForm(LoginForm $form)
    {
        $this->form = $form;
    }
    
    public function loginAction()
    {   
        return new ViewModel(array(
            'form' => $this->form
        ));   
    }
    
    public function logoutAction()
    {
        $this->auth->clear();
        return $this->redirect()->toRoute('home');
    }
    
    public function authenticateAction()
    {
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return $this->redirect()->toRoute('user/login');
        }
        
        // Validate
        $post = $request->getPost();
        $form = $this->form;
        $form->setData($post);
        
        $viewModel = new ViewModel();
        
        $viewModel->setTemplate('user/auth/login');

        if (!$form->isValid()) {
        	$this->flashMessenger()->addInfoMessage(
        		'There were one or more isues with your submission. Please correct them as indicated below.'
        	);
        	
            return $viewModel->setVariables(['form' => $form]); // re-render the login form
        }

        $data = $form->getData();
        
        if (false === $this->auth->doAuthentication($data['email'], $data['passwd'])) {
        	$this->flashMessenger()->addErrorMessage(
        		'Login failed, Please try again.'
        	);

            return $viewModel->setVariables(['form' => $form]); // re-render the login form
        }
        
        $return = ($post['returnTo']) ? $post['returnTo'] : 'home';
        
        if ('admin' === $this->identity()->getRole()) {
            return $this->redirect()->toRoute('admin');
        }
        
        return $this->redirect()->toRoute($return);
    }
}
