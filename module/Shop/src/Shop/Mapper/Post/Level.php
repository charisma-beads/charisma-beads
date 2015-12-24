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
 * Class Level
 *
 * @package Shop\Mapper\Post
 */
class Level extends AbstractDbMapper
{
    protected $table = 'postLevel';
    protected $primary = 'postLevelId';
}
