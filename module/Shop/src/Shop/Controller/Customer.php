<?php
namespace Shop\Controller;

use Application\Controller\AbstractCrudController;

class Customer extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'name');
	protected $serviceName = 'Shop\Service\Customer';
	protected $route = 'admin/shop/customer';
	
}
