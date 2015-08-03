<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Mapper\Post
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Mapper\Post;

use UthandoCommon\Mapper\AbstractDbMapper;

/**
 * Class Unit
 *
 * @package Shop\Mapper\Post
 */
class Unit extends AbstractDbMapper
{
	protected $table = 'postUnit';
	protected $primary = 'postUnitId';
}
