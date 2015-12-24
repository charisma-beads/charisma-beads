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

use UthandoCommon\Service\AbstractRelationalMapperService;

/**
 * Class Cost
 *
 * @package Shop\Service\Post
 */
class Cost extends AbstractRelationalMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopPostCost';
    
    protected $tags = [
        'post-cost', 'post-level', 'post-zone',
    ];

    /**
     * @var array
     */
    protected $referenceMap = [
        'postLevel' => [
            'refCol'    => 'postLevelId',
            'service'   => 'ShopPostLevel',
        ],
        'postZone'  => [
            'refCol'    => 'postZoneId',
            'service'   => 'ShopPostZone',
        ],
    ];
}
