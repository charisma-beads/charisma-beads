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

use Shop\Service\PostZoneService;
use UthandoCommon\Controller\AbstractCrudController;

/**
 * Class PostZone
 *
 * @package Shop\Controller
 */
class PostZoneController extends AbstractCrudController
{
	protected $controllerSearchOverrides = array('sort' => 'zone');
	protected $serviceName = PostZoneService::class;
	protected $route = 'admin/shop/post/zone';
}
