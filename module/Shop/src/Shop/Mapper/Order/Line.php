<?php
namespace Shop\Mapper\Order;

use UthandoCommon\Mapper\AbstractMapper;

class Line extends AbstractMapper
{
    protected $table = 'orderLine';
    protected $primary = 'orderLineId';
    protected $model = 'Shop\Model\Order\Line';
    protected $hydrator = 'Shop\Hydrator\Order\Line';
    
    public function getOrderLinesByOrderId($id)
    {
        $select = $this->getSelect();
        $select->where->equalTo('orderId', $id);
        return $this->fetchResult($select);
    }
}
