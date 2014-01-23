<?php
namespace Shop\Service\Product;

use Application\Service\AbstractService;

class GroupPrice extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\ProductGroupPrice';
    protected $form = 'Shop\Form\ProductGroupPrice';
    protected $inputFilter = 'Shop\InputFilter\ProductGroupPrice';
}
