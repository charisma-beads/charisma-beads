<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractMapper;

class OrderStatus extends AbstractMapper
{
    protected $table = 'orderStatus';
    protected $primary = 'orderStatusId';
    protected $model = 'Shop\Model\OrderStatus';
    protected $hydrator = 'Shop\Hydrator\OrderStatus';
}
