<?php
namespace Shop\Service\Product;

use Application\Service\AbstractService;

class Size extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\ProductSize';
    protected $form = '';
    protected $inputFilter = '';
}
