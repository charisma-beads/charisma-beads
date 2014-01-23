<?php
namespace Shop\Service\Order;

use Application\Service\AbstractService;

class Line extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\OrderLine';
    protected $form = 'Shop\Form\OrderLine';
    protected $inputFilter = 'Shop\InputFilter\OrderLine';
}