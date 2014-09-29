<?php
namespace Shop\Mapper\Order;

use UthandoCommon\Mapper\AbstractDbMapper;

class Status extends AbstractDbMapper
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
