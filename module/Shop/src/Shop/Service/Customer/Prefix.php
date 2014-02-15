<?php
namespace Shop\Service\Customer;

use Application\Service\AbstractService;

class Prefix extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\CustomerPrefix';
    protected $form = 'Shop\Form\CustomerPrefix';
    protected $inputFilter = 'Shop\InputFilter\CustomerPrefix';
}
