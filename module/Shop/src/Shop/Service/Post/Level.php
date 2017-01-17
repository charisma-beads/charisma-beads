<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Post
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service\Post;

use UthandoCommon\Service\AbstractMapperService;

/**
 * Class Level
 *
 * @package Shop\Service\Post
 */
class Level extends AbstractMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopPostLevel';
    
    protected $tags = [
       'post-level',
    ];
	
}
