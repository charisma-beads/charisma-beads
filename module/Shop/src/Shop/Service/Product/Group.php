<?php
namespace Shop\Service\Product;

use UthandoCommon\Service\AbstractService;

class Group extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\Product\Group';
    protected $form = 'Shop\Form\Product\Group';
    protected $inputFilter = 'Shop\InputFilter\Product\Group';
}
