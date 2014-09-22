<?php
namespace Shop\Mapper\Order;

use UthandoCommon\Mapper\AbstractMapper;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Expression;

class Order extends AbstractMapper
{
    protected $table = 'order';
    protected $primary = 'orderId';

    public function getCurrentOrders()
    {
        $select = $this->getSql()->select($this->table);
        $select->join(
            'orderStatus',
            'order.orderStatusId=orderStatus.orderStatusId',
            array()
        )->where
            ->notEqualTo('orderStatus', 'Cancelled')
            ->notEqualTo('orderStatus', 'Dispatched')
            ->notEqualTo('orderStatus', 'Acknowledged')
            ->notEqualTo('orderStatus', 'Ready For Collection');

        $select     = $this->setSortOrder($select, array('-orderDate'));
        $resultSet  = $this->fetchResult($select);

        return $resultSet;
    }

    public function getOrderByOrderNumber($orderNumber)
    {
        $select = $this->getSelect();
        $select->where->equalTo('orderNumber', $orderNumber);
        $resultSet = $this->fetchResult($select);

        return $resultSet->current();
    }
    
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
