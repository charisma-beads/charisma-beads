<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Controller\Tax
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

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
