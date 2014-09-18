<?php
namespace Shop\Service\Post;

use UthandoCommon\Service\AbstractMapperService;

class Unit extends AbstractMapperService
{
    protected $mapperClass = 'Shop\Mapper\Post\Unit';
    protected $form = 'Shop\Form\Post\Unit';
    protected $inputFilter = 'Shop\InputFilter\Post\Unit';

    protected $serviceAlias = 'ShopPostUnit';
}
