<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractMapper;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Expression;

class Order extends AbstractMapper
{
    protected $table = 'order';
    protected $primary = 'orderId';
    protected $model = 'Shop\Model\Order';
    protected $hydrator = 'Shop\Hydrator\Order';
    
    public function getMaxOrderNumber()
    {
        $select = $this->getSelect();
        $select->columns(array(
        	'orderNumber' => new Expression('(MAX(orderNumber))')
        ));
        
        $resultSet = $this->fetchResult($select, new ResultSet());
        $row = $resultSet->current();
        return $row;
    }
}
