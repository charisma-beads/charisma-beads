<?php
namespace Application\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class AdminController extends AbstractController
{
	public function dashboardAction()
	{
		if (!$this->isAllowed('Admin')) {
			return $this->redirect()->toRoute('home');
		}
		
		return new ViewModel();
	}
}
