<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractMapper;

class OrderLine extends AbstractMapper
{
    protected $table = 'orderLine';
    protected $primary = 'orderLineId';
    protected $model = 'Shop\Model\OderLine';
    protected $hydrator = 'Shop\Hydrator\OrderLine';
}
