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
 * Class PostCost
 *
 * @package Shop\Controller\Post
 */
class PostCost extends AbstractCrudController
{
	protected $controllerSearchOverrides = array('sort' => 'cost');
	protected $serviceName = 'ShopPostCost';
	protected $route = 'admin/shop/post/cost';
}
