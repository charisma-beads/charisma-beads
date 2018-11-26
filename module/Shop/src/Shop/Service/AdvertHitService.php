<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Advert
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service;

use Shop\Hydrator\AdvertHitHydrator;
use Shop\Mapper\AdvertHitMapper;
use Shop\Model\AdvertHitModel;
use UthandoCommon\Service\AbstractRelationalMapperService;

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
