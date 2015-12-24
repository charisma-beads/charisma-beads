<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Controller\Country
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Controller\Country;

use UthandoCommon\Controller\AbstractCrudController;

/**
 * Class Country
 *
 * @package Shop\Controller\Country
 */
class Country extends AbstractCrudController
{
	protected $controllerSearchOverrides = array('sort' => 'country');
	protected $serviceName = 'ShopCountry';
	protected $route = 'admin/shop/country';
}
