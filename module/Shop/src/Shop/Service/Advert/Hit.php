<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Advert
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service\Advert;

use UthandoCommon\Service\AbstractRelationalMapperService;

/**
 * Class Hit
 *
 * @package Shop\Service\Advert
 */
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
