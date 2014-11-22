<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoShop
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */
namespace Shop\Controller\Post;

use UthandoCommon\Controller\AbstractCrudController;

/**
 * Class PostLevel
 *
 * @package Shop\Controller\Post
 */
class PostLevel extends AbstractCrudController
{
	protected $searchDefaultParams = ['sort' => 'postLevel'];
	protected $serviceName = 'Shop\Service\Post\Level';
	protected $route = 'admin/shop/post/level';
}
