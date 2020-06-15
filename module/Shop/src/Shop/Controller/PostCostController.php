<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Controller\Post
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Controller;

use Shop\Service\PostCostService;
use Common\Controller\AbstractCrudController;

/**
 * Class PostCost
 *
 * @package Shop\Controller
 */
class PostCostController extends AbstractCrudController
{
	protected $controllerSearchOverrides = array('sort' => 'cost');
	protected $serviceName = PostCostService::class;
	protected $route = 'admin/shop/post/cost';
}
