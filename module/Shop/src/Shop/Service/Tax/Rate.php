<?php
namespace Shop\Service\Tax;

use UthandoCommon\Service\AbstractService;

class Rate extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\Tax\Rate';
    protected $form = 'Shop\Form\Tax\Rate';
    protected $inputFilter = 'Shop\InputFilter\Tax\Rate';
    
}
