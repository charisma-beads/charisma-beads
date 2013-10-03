<?php
namespace Application\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class AdminController extends AbstractController
{
	public function dashboardAction()
	{
		return new ViewModel();
	}
}
