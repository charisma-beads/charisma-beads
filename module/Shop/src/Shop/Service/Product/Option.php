<?php

namespace Shop\Service\Product;

use UthandoCommon\Service\AbstractService;

class Option extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\Product\Option';
    protected $form = 'Shop\Form\Product\Option';
    protected $inputFilter = 'Shop\InputFilter\Product\Option';
} 