<?php
namespace Shop\Controller\Country;

use UthandoCommon\Controller\AbstractCrudController;

class Country extends AbstractCrudController
{
	protected $controllerSearchOverrides = array('sort' => 'country');
	protected $serviceName = 'ShopCountry';
	protected $route = 'admin/shop/country';
}
