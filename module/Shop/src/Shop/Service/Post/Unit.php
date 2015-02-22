<?php
namespace Shop\Service\Post;

use UthandoCommon\Service\AbstractMapperService;

class Unit extends AbstractMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopPostUnit';
    
    protected $tags = [
        'post-unit',
    ];
}
