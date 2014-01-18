<?php
namespace Shop\Service\Tax;

use Application\Service\AbstractService;

class Rate extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\TaxRate';
    protected $form = 'Shop\Form\TaxRate';
    protected $inputFilter = 'Shop\InputFilter\TaxRate';
    
}
