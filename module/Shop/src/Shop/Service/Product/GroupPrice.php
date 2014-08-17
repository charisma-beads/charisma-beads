<?php
namespace Shop\Service\Product;

use UthandoCommon\Service\AbstractService;

class GroupPrice extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\Product\GroupPrice';
    protected $form = 'Shop\Form\Product\GroupPrice';
    protected $inputFilter = 'Shop\InputFilter\Product\GroupPrice';
}
