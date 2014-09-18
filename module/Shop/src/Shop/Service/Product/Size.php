<?php
namespace Shop\Service\Product;

use UthandoCommon\Service\AbstractMapperService;

class Size extends AbstractMapperService
{
    protected $mapperClass = 'Shop\Mapper\Product\Size';
    protected $form = '';
    protected $inputFilter = '';

    protected $serviceAlias = 'ShopProductSize';
}
