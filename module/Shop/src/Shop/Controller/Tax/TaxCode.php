<?php
namespace Shop\Controller\Tax;

use Application\Controller\AbstractCrudController;

class TaxCode extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'taxCodeId');
	protected $serviceName = 'Shop\Service\TaxCode';
	protected $route = 'admin/shop/tax/code';
}
