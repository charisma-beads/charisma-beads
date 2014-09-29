<?php
namespace Shop\Mapper\Order;

use UthandoCommon\Mapper\AbstractDbMapper;

class Line extends AbstractDbMapper
{
    protected $table = 'orderLine';
    protected $primary = 'orderLineId';
    
    public function getOrderLinesByOrderId($id)
    {
        $select = $this->getSelect();
        $select->where->equalTo('orderId', $id);
        return $this->fetchResult($select);
    }
}
