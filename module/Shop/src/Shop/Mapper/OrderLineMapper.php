<?php

namespace Shop\Mapper;

use Common\Mapper\AbstractDbMapper;

/**
 * Class Line
 *
 * @package Shop\Mapper
 */
class OrderLineMapper extends AbstractDbMapper
{
    protected $table = 'orderLine';
    protected $primary = 'orderLineId';
    
    public function getOrderLinesByOrderId($id)
    {
        $select = $this->getSelect();
        $select->where->equalTo('orderId', $id);
        //$select = $this->setSortOrder($select, 'sortOrder');
        return $this->fetchResult($select);
    }
}
