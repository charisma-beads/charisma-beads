<?php
namespace Shop\Controller;

use Application\Controller\AbstractCrudController;

class TaxRateController extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'taxRate');
	protected $serviceName = 'Shop\Service\TaxRate';
	protected $route = 'admin/shop/tax/rate';
}
