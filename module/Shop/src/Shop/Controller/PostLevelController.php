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

use Shop\Service\PostLevelService;
use UthandoCommon\Controller\AbstractCrudController;

/**
 * Class PostLevel
 *
 * @package Shop\Controller
 */
class PostLevelController extends AbstractCrudController
{
	protected $controllerSearchOverrides = ['sort' => 'postLevel'];
	protected $serviceName = PostLevelService::class;
	protected $route = 'admin/shop/post/level';
}
