<?php
namespace Shop\Mapper\Customer;

use UthandoCommon\Mapper\AbstractMapper;
use Zend\Db\Sql\Select;

class Address extends AbstractMapper
{
    protected $table = 'customerAddress';
    protected $primary = 'customerAddressId';
    
    public function getAllByCustomerId($id)
    {
        $id = (int) $id;
        $select = $this->getSelect();
        $select->where->equalTo('customerId', $id);
        
        $resultSet = $this->fetchResult($select);
        return $resultSet;
    }
    
    public function getAddressByUserId($id, $billingOrDelivery)
    {
        $id = (int) $id;
        $billingOrDelivery = strtolower($billingOrDelivery) . 'AddressId';
    
        $select = $this->getSql()->select();
        $select->from($this->table)
        ->join(
            'customer',
            'customerAddress.customerAddressId=customer.' . $billingOrDelivery,
            array(),
            Select::JOIN_LEFT
        )->where->equalTo('userId', $id);
    
        $resultSet = $this->fetchResult($select);
        $row = $resultSet->current();
        return $row;
    }
}
