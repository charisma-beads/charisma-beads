<?php
namespace Shop\Service;

use Application\Service\AbstractService;

class Order extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\Order';
    protected $form = 'Shop\Form\Order';
    protected $inputFilter = 'Shop\InputFilter\Order';
}
