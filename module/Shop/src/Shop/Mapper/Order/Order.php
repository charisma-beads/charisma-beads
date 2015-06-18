<?php
namespace Shop\Mapper\Order;

use UthandoCommon\Mapper\AbstractDbMapper;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;

class Order extends AbstractDbMapper
{
    protected $table = 'order';
    protected $primary = 'orderId';

    public function getCurrentOrders()
    {
        $select = $this->getSql()->select($this->table);
        $select->join(
            'orderStatus',
            'order.orderStatusId=orderStatus.orderStatusId',
            []
        )->where
            ->notEqualTo('orderStatus', 'Cancelled')
            ->notEqualTo('orderStatus', 'Dispatched')
            ->notEqualTo('orderStatus', 'Acknowledged')
            ->notEqualTo('orderStatus', 'Ready For Collection');

        $select     = $this->setSortOrder($select, ['-orderDate']);
        $resultSet  = $this->fetchResult($select);

        return $resultSet;
    }

    public function getOrdersByCustomerId($id)
    {
        $select = $this->getSelect();
        $select->where->equalTo('customerId', $id);
        $resultSet = $this->fetchResult($select);

        return $resultSet;
    }

    /**
     * @return array|\ArrayObject|null|object
     */
    public function getMinMaxYear()
    {
        $select = $this->getSelect();
        $select->columns([
            'minYear' => new Expression("MIN(DATE_FORMAT(order.orderDate, '%Y'))"),
            'maxYear' => new Expression("MAX(DATE_FORMAT(order.orderDate, '%Y'))"),
        ]);

        $rowSet = $this->fetchResult($select, new ResultSet());
        $row = $rowSet->current();

        return $row;
    }

    /**
     * @param null|string $startDate
     * @param null|string $endDate
     * @return \Zend\Db\ResultSet\HydratingResultSet|ResultSet|\Zend\Paginator\Paginator
     */
    public function getMonthlyTotals($startDate = null, $endDate = null)
    {
        $select = $this->getSelect();
        $select->columns([
            'numOrders'     => new Expression('COUNT(order.orderId)'),
            'total'         => new Expression('SUM(order.total)'),
            //'monthLong'     => new Expression("DATE_FORMAT(order.orderDate, '%M')"),
            //'monthShort'    => new Expression("DATE_FORMAT(order.orderDate, '%m')"),
            'month'         => new Expression("DATE_FORMAT(order.orderDate, '%m')"),
            'year'          => new Expression("DATE_FORMAT(order.orderDate, '%Y')"),
        ])->join(
            'orderStatus',
            'order.orderStatusId=orderStatus.orderStatusId',
            []
        )->group([
            'year', 'month'
        ])->order([
            'year ' . Select::ORDER_ASCENDING,
            'month ' . Select::ORDER_ASCENDING,
        ])->where->notEqualTo(
            'orderStatus', 'Cancelled'
        );

        if ($startDate && $endDate) {
            $select->where->between('order.orderDate', $startDate, $endDate);
        }

        return $this->fetchResult($select, new ResultSet());
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
        $select->columns([
        	'orderNumber' => new Expression('(MAX(orderNumber))')
        ]);
        
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
        $select = $this->setSortOrder($select, ['-orderDate']);
        
        return $this->fetchResult($select);
    }
    
    public function getCustomerOrderSelect()
    {
        $select = $this->getSql()->select($this->table);
        $select->join(
            'customer',
            'order.customerId=customer.customerId',
            []
        );
        
        return $select;
    }
}
