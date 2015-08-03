<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Controller\Tax
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Controller\Tax;

use UthandoCommon\Controller\AbstractCrudController;

/**
 * Class TaxCode
 *
 * @package Shop\Controller\Tax
 */
class TaxCode extends AbstractCrudController
{
	protected $controllerSearchOverrides = array('sort' => 'taxCodeId');
	protected $serviceName = 'ShopTaxCode';
	protected $route = 'admin/shop/tax/code';
}
