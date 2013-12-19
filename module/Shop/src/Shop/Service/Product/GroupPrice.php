<?php
namespace Shop\Service\Product;

use Application\Service\AbstractService;

class GroupPrice extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\ProductGroupPrice';
    protected $form = '';
    protected $inputFilter = '';
}
