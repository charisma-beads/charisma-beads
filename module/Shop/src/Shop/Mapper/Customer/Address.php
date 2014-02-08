<?php
namespace Shop\Mapper\Customer;

use Application\Mapper\AbstractMapper;
use Zend\Db\Sql\Select;

class Address extends AbstractMapper
{
    protected $table = 'customerAddress';
    protected $primary = 'customerAddressId';
    protected $model = 'Shop\Model\Customer\Address';
    protected $hydrator = 'Shop\Hydrator\Customer\Address';
    
    public function getDeliveryAddressByUserId($id)
    {
        $id = (int) $id;
    
        $select = $this->getSql()->select();
        $select->from($this->table)
        ->join(
            'customer',
            'customerAddress.customerAddressId = customer.deliveryAddressId',
            array(Select::SQL_STAR),
            Select::JOIN_LEFT
        )->join(
            'country',
            'customerAddress.countryId=country.countryId',
            array('country' => 'country'),
            Select::JOIN_LEFT
        )->where
        ->equalTo('userId', $id);
    
        $resultSet = $this->fetchResult($select);
        $row = $resultSet->current();
        return $row;
    }
    
    public function getBillingAddressByUserId($id)
    {
        $id = (int) $id;
    
        $select = $this->getSql()->select();
        $select->from($this->table)
        ->join(
            'customer',
            'customerAddress.customerAddressId = customer.billingAddressId',
            array(Select::SQL_STAR),
            Select::JOIN_LEFT
        )->join(
            'country',
            'customerAddress.countryId=country.countryId',
            array('country' => 'country'),
            Select::JOIN_LEFT
        )->where
        ->equalTo('userId', $id);
    
        $resultSet = $this->fetchResult($select);
        $row = $resultSet->current();
        return $row;
    }
    
}
