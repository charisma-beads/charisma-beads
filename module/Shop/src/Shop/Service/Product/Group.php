<?php
namespace Shop\Service\Product;

use UthandoCommon\Service\AbstractMapperService;

class Group extends AbstractMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopProductGroup';
    
    protected $tags = [
        'group',
    ];
}
