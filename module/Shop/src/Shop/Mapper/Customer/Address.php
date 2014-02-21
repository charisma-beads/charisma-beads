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
