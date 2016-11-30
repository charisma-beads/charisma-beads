<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Controller\Post
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Controller\Post;

use UthandoCommon\Controller\AbstractCrudController;

/**
 * Class PostZone
 *
 * @package Shop\Controller\Post
 */
class PostZone extends AbstractCrudController
{
	protected $controllerSearchOverrides = array('sort' => 'zone');
	protected $serviceName = 'ShopPostZone';
	protected $route = 'admin/shop/post/zone';
}
