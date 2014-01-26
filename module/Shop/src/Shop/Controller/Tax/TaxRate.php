<?php
namespace Shop\Controller\Tax;

use Application\Controller\AbstractCrudController;

class TaxRate extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'taxRate');
	protected $serviceName = 'Shop\Service\TaxRate';
	protected $route = 'admin/shop/tax/rate';
}
