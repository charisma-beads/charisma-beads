<?php
namespace Shop\Service\Advert;

use UthandoCommon\Service\AbstractRelationalMapperService;

class Hit extends AbstractRelationalMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopAdvertHit';
    
    /**
     * @var array
     */
    protected $referenceMap = [
        'advert'  => [
            'refCol'    => 'advertId',
            'service'   => 'ShopAdvert',
        ],
        'user'  => [
            'refCol'    => 'userId',
            'service'   => 'UthandoUser',
        ],
    ];
    
    protected $tags = [
        'advert', 'advertHit',
    ];
}
