<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Controller\Country
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

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
