<?php
namespace Shop\Service\Stock;

use Application\Service\AbstractService;

class Status extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\StockStatus';
    protected $form = '';
    protected $inputFilter = '';
}
