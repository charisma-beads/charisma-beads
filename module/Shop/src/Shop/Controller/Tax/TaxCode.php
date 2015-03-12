<?php
namespace Shop\Controller\Tax;

use UthandoCommon\Controller\AbstractCrudController;

class TaxCode extends AbstractCrudController
{
	protected $controllerSearchOverrides = array('sort' => 'taxCodeId');
	protected $serviceName = 'ShopTaxCode';
	protected $route = 'admin/shop/tax/code';
}
