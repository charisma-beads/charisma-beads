<?php
namespace Shop\Mapper\Order;

use Application\Mapper\AbstractMapper;

class Status extends AbstractMapper
{
    protected $table = 'orderStatus';
    protected $primary = 'orderStatusId';
    protected $model = 'Shop\Model\Order\Status';
    protected $hydrator = 'Shop\Hydrator\Order\Status';
}
