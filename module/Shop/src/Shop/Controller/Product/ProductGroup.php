<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Controller\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Controller\Product;

use UthandoCommon\Controller\AbstractCrudController;

/**
 * Class ProductGroup
 *
 * @package Shop\Controller\Product
 */
class ProductGroup extends AbstractCrudController
{
	protected $controllerSearchOverrides = array('sort' => 'productGroupId');
	protected $serviceName = 'ShopProductGroup';
	protected $route = 'admin/shop/group';
	
}
