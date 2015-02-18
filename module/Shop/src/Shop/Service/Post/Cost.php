<?php

namespace Shop\Service\Post;

use UthandoCommon\Service\AbstractRelationalMapperService;

class Cost extends AbstractRelationalMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopPostCost';

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
