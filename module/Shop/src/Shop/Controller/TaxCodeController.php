<?php

namespace Shop\Controller;

use Shop\Service\TaxCodeService;
use Common\Controller\AbstractCrudController;

/**
 * Class TaxCode
 *
 * @package Shop\Controller
 */
class TaxCodeController extends AbstractCrudController
{
	protected $controllerSearchOverrides = array('sort' => 'taxCodeId');
	protected $serviceName = TaxCodeService::class;
	protected $route = 'admin/shop/tax/code';
}
