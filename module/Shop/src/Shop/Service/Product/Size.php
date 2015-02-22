<?php
namespace Shop\Service\Product;

use UthandoCommon\Service\AbstractMapperService;

class Size extends AbstractMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopProductSize';
    
    protected $tags = [
        'size',
    ];
}
