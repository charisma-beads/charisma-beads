<?php
namespace Shop\Mapper\Order;

use Application\Mapper\AbstractMapper;

class Line extends AbstractMapper
{
    protected $table = 'orderLine';
    protected $primary = 'orderLineId';
    protected $model = 'Shop\Model\Order\Line';
    protected $hydrator = 'Shop\Hydrator\Order\Line';
}
