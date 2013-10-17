<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractMapper;

class Order extends AbstractMapper
{
    protected $table = 'order';
    protected $primary = 'orderId';
    protected $model = 'Shop\Model\Order';
    protected $hydrator = 'Shop\Hydrator\Order';
}
