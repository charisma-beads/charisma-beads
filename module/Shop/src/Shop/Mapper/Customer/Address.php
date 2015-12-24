<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Mapper\Customer
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Mapper\Customer;

use UthandoCommon\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Select;

/**
 * Class Address
 *
 * @package Shop\Mapper\Customer
 */
class Address extends AbstractDbMapper
{
    protected $table = 'customerAddress';
    protected $primary = 'customerAddressId';

    /**
     * @param $id
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
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
