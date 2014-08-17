<?php
namespace Shop\Service\Post;

use UthandoCommon\Service\AbstractService;

class Unit extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\Post\Unit';
    protected $form = 'Shop\Form\Post\Unit';
    protected $inputFilter = 'Shop\InputFilter\Post\Unit';
}
