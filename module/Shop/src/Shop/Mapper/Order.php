<?php
namespace Shop\Mapper;

use UthandoCommon\Mapper\AbstractMapper;
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
    
    public function getOrderByUserId($id, $userId)
    {
        $select = $this->getCustomerOrderSelect();
        $select->where
            ->equalTo('userId', $userId)
            ->and->equalTo('orderId', $id);
        
        $resultSet = $this->fetchResult($select);
        $row = $resultSet->current();
        
        return $row;
    }
    
    public function getOrdersByUserId($id)
    {
        $select = $this->getCustomerOrderSelect();
        $select->where->equalTo('userId', $id);
        $select = $this->setSortOrder($select, array('-orderDate'));
        
        return $this->fetchResult($select);
    }
    
    public function getCustomerOrderSelect()
    {
        $select = $this->getSql()->select($this->table);
        $select->join(
            'customer',
            'order.customerId=customer.customerId',
            array()
        );
        
        return $select;
    }
}
