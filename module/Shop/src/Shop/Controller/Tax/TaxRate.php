<?php
namespace Shop\Controller\Tax;

use UthandoCommon\Controller\AbstractCrudController;

class TaxRate extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'taxRate');
	protected $serviceName = 'Shop\Service\Tax\Rate';
	protected $route = 'admin/shop/tax/rate';
}
