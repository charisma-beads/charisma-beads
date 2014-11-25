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
            'service'   => 'Shop\Service\Post\Level',
        ],
        'postZone'  => [
            'refCol'    => 'postZoneId',
            'service'   => 'Shop\Service\Post\Zone',
        ],
    ];
}
