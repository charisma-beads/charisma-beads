<?php

namespace Shop\Mapper;

use Common\Mapper\AbstractDbMapper;

/**
 * Class Status
 *
 * @package Shop\Mapper
 */
class OrderStatusMapper extends AbstractDbMapper
{
    protected $table = 'orderStatus';
    protected $primary = 'orderStatusId';
    
    public function getStatusByName($status)
    {
        $select = $this->getSelect();
        $select->where->equalTo('orderStatus', $status);
        $resultSet = $this->fetchResult($select);
        $row = $resultSet->current();
        return $row;
    }
}
