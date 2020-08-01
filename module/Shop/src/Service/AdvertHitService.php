<?php

namespace Shop\Service;

use Shop\Hydrator\AdvertHitHydrator;
use Shop\Mapper\AdvertHitMapper;
use Shop\Model\AdvertHitModel;
use Common\Service\AbstractRelationalMapperService;

/**
 * Class Hit
 *
 * @package Shop\Service
 */
class AdvertHitService extends AbstractRelationalMapperService
{
    protected $hydrator     = AdvertHitHydrator::class;
    protected $mapper       = AdvertHitMapper::class;
    protected $model        = AdvertHitModel::class;
    
    /**
     * @var array
     */
    protected $referenceMap = [
        'advert'  => [
            'refCol'    => 'advertId',
            'service'   => AdvertService::class,
        ]
    ];
    
    protected $tags = [
        'advert', 'advertHit',
    ];
}
