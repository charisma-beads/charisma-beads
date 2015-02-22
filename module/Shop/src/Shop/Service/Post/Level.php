<?php

namespace Shop\Service\Post;

use UthandoCommon\Service\AbstractMapperService;

class Level extends AbstractMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopPostLevel';
    
    protected $tags = [
       'post-level',
    ];
	
}
