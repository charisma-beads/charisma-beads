<?php
namespace Shop\Service;

use Application\Service\AbstractService;

class Customer extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\Customer';
    protected $form = 'Shop\Form\Customer';
    protected $inputFilter = 'Shop\InputFilter\Customer';
    
}
