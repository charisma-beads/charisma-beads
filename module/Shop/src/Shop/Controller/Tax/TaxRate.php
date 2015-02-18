<?php
namespace Shop\Controller\Tax;

use UthandoCommon\Controller\AbstractCrudController;

class TaxRate extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'taxRate');
	protected $serviceName = 'ShopTaxRate';
	protected $route = 'admin/shop/tax/rate';
}
