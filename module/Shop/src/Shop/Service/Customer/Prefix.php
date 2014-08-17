<?php
namespace Shop\Service\Customer;

use UthandoCommon\Service\AbstractService;

class Prefix extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\Customer\Prefix';
    protected $form = 'Shop\Form\Customer\Prefix';
    protected $inputFilter = 'Shop\InputFilter\Customer\Prefix';
}
