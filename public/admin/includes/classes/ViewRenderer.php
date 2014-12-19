<?php

use Zend\View\Renderer\PhpRenderer;
use Zend\Form\View\HelperConfig;
use Zend\View\Resolver\TemplateMapResolver;
use Zend\View\Model\ViewModel;

class ViewRenderer 
{	
	protected $_view;
	
	public function __construct()
	{
		$zfView = new PhpRenderer();
		$this->plugins = $zfView->getHelperPluginManager();
		$config  = new HelperConfig();
		$config->configureServiceManager($this->plugins);
		
		$zfView->setResolver(new TemplateMapResolver(array(
			'login' => $_SERVER['DOCUMENT_ROOT'] . '/shop/html/login.phtml',
			'reset-password' => $_SERVER['DOCUMENT_ROOT'] . '/shop/html/forgot-password.phtml',
			'register' => $_SERVER['DOCUMENT_ROOT'] . '/shop/html/register.phtml',
			'change-password' => $_SERVER['DOCUMENT_ROOT'] . '/shop/html/change-password.phtml',
			'contact' => $_SERVER['DOCUMENT_ROOT'] . '/shop/html/contact.phtml',
			'thank-you' => $_SERVER['DOCUMENT_ROOT'] . '/shop/html/thank-you.phtml',
			'register' => $_SERVER['DOCUMENT_ROOT'] . '/shop/html/register.phtml',
			'province-select' => $_SERVER['DOCUMENT_ROOT'] . '/shop/html/province-select.phtml',
			'register-email' => $_SERVER['DOCUMENT_ROOT'] . '/shop/html/register-email.phtml',
            'register-thank-you' => $_SERVER['DOCUMENT_ROOT'] . '/shop/html/register-thank-you.phtml',
            'activate' => $_SERVER['DOCUMENT_ROOT'] . '/shop/html/activate.phtml',
        )));
	
		$this->_view = $zfView;
	}
	
	public function render($partial, $params = [])
	{
		global $https;
		
		$defaultParams = array(
			'https'	=> $https,
		);
		
		$params = array_merge($defaultParams, $params);
		
		$viewModel = new ViewModel($params);
		$viewModel->setTemplate($partial);
	
		return $this->_view->render($viewModel);
	}
}

?>