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
 * Class Zone
 *
 * @package Shop\Service\Post
 */
class Zone extends AbstractMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopPostZone';
    
    protected $tags = [
        'post-zone',
    ];
	
}
