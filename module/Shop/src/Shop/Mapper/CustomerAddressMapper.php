<?php

namespace Shop\Mapper;

use Common\Mapper\AbstractDbMapper;
use Laminas\Db\Sql\Select;

/**
 * Class Address
 *
 * @package Shop\Mapper
 */
class CustomerAddressMapper extends AbstractDbMapper
{
    protected $table = 'customerAddress';
    protected $primary = 'customerAddressId';

    /**
     * @param $id
     * @return \Laminas\Db\ResultSet\HydratingResultSet|\Laminas\Db\ResultSet\ResultSet|\Laminas\Paginator\Paginator
     */
    public function getAllByCustomerId($id)
    {
        $id = (int) $id;
        $select = $this->getSelect();
        $select->where->equalTo('customerId', $id);
        
        $resultSet = $this->fetchResult($select);
        return $resultSet;
    }

    /**
     * @param $id
     * @param $billingOrDelivery
     * @return array|\ArrayObject|null|object
     */
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
