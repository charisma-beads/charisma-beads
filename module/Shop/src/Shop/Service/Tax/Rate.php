<?php
namespace Shop\Service\Tax;

use UthandoCommon\Service\AbstractMapperService;

class Rate extends AbstractMapperService
{
    protected $mapperClass = 'Shop\Mapper\Tax\Rate';
    protected $form = 'Shop\Form\Tax\Rate';
    protected $inputFilter = 'Shop\InputFilter\Tax\Rate';

    protected $serviceAlias = 'ShopTaxRate';
    
}
