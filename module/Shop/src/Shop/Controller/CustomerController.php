<?php
namespace Shop\Controller;

use Application\Controller\AbstractCrudController;

class CustomerController extends AbstractCrudController
{
	
	protected $searchDefaultParams = array('sort' => 'name');
	protected $serviceName = 'Shop\Service\Customer';
	protected $route = 'admin/shop/customer';
}
