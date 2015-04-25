<?php
namespace Shop\Service\Advert;

use UthandoCommon\Service\AbstractMapperService;

class Advert extends AbstractMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopAdvert';
    
    protected $tags = [
        'advert',
    ];
}
