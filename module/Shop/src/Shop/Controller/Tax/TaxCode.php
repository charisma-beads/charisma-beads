<?php
namespace Shop\Controller\Tax;

use UthandoCommon\Controller\AbstractCrudController;

class TaxCode extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'taxCodeId');
	protected $serviceName = 'Shop\Service\Tax\Code';
	protected $route = 'admin/shop/tax/code';
}
