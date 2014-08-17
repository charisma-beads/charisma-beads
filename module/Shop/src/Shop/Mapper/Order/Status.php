<?php
namespace Shop\Mapper\Order;

use UthandoCommon\Mapper\AbstractMapper;

class Status extends AbstractMapper
{
    protected $table = 'orderStatus';
    protected $primary = 'orderStatusId';
    protected $model = 'Shop\Model\Order\Status';
    protected $hydrator = 'Shop\Hydrator\Order\Status';
    
    public function getStatusByName($status)
    {
        $select = $this->getSelect();
        $select->where->equalTo('orderStatus', $status);
        $resultSet = $this->fetchResult($select);
        $row = $resultSet->current();
        return $row;
    }
}
