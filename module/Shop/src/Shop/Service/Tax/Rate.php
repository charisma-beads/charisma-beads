<?php
namespace Shop\Service\Tax;

use UthandoCommon\Service\AbstractMapperService;

class Rate extends AbstractMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopTaxRate';
    
    protected $tags = [
        'tax-rate',
    ];
    
}
