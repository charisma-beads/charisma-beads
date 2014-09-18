<?php
namespace Shop\Service\Customer;

use UthandoCommon\Service\AbstractMapperService;

class Prefix extends AbstractMapperService
{
    protected $mapperClass = 'Shop\Mapper\Customer\Prefix';
    protected $form = 'Shop\Form\Customer\Prefix';
    protected $inputFilter = 'Shop\InputFilter\Customer\Prefix';

    protected $serviceAlias = 'ShopCustomerPrefix';
}
