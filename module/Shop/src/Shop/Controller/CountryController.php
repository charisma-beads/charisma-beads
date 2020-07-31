<?php

namespace Shop\Controller;

use Shop\Service\CountryService;
use Common\Controller\AbstractCrudController;

/**
 * Class Country
 *
 * @package Shop\Controller
 */
class CountryController extends AbstractCrudController
{
	protected $controllerSearchOverrides = array('sort' => 'country');
	protected $serviceName = CountryService::class;
	protected $route = 'admin/shop/country';
}
