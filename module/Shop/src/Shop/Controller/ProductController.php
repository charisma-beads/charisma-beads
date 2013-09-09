<?php
namespace Shop\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class ProductController extends AbstractController
{
	public function viewAction()
	{
		return new ViewModel();
	}
}
