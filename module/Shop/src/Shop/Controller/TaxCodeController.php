<?php
namespace Shop\Controller;

use Application\Controller\AbstractCrudController;

class TaxCodeController extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'taxCodeId');
	protected $serviceName = 'Shop\Service\TaxCode';
	protected $route = 'admin/shop/tax/code';
}
