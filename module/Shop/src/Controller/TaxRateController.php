<?php

namespace Shop\Controller;

use Shop\Service\TaxRateService;
use Common\Controller\AbstractCrudController;

/**
 * Class TaxRate
 *
 * @package Shop\Controller
 */
class TaxRateController extends AbstractCrudController
{
	protected $controllerSearchOverrides = array('sort' => 'taxRate');
	protected $serviceName = TaxRateService::class;
	protected $route = 'admin/shop/tax/rate';
}
