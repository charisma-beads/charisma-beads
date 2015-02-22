<?php

namespace Shop\Service\Post;

use UthandoCommon\Service\AbstractMapperService;

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
