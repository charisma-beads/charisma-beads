<?php
namespace Shop\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class CheckoutController extends AbstractController
{
	public function indexAction()
	{
		if ($this->identity()) {
			return $this->redirect()->toRoute('shop/checkout', array(
				'action' => 'confirm-address'
			));
		}
		
		return new ViewModel();
	}
	
	public function confirmAddressAction()
	{
		return new ViewModel();
	}
}