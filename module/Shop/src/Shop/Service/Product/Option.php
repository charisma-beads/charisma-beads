<?php

namespace Shop\Service\Product;

use UthandoCommon\Service\AbstractMapperService;

class Option extends AbstractMapperService
{
    protected $mapperClass = 'Shop\Mapper\Product\Option';
    protected $form = 'Shop\Form\Product\Option';
    protected $inputFilter = 'Shop\InputFilter\Product\Option';

    protected $serviceAlias = 'ShopProductOption';
} 