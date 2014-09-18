<?php
namespace Shop\Service\Product;

use UthandoCommon\Service\AbstractMapperService;

class Group extends AbstractMapperService
{
    protected $mapperClass = 'Shop\Mapper\Product\Group';
    protected $form = 'Shop\Form\Product\Group';
    protected $inputFilter = 'Shop\InputFilter\Product\Group';

    protected $serviceAlias = 'ShopProductGroup';
}
