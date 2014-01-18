<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractMapper;
use Zend\Db\Sql\Select;

class Customer extends AbstractMapper
{
    protected $table = 'customer';
    protected $primary = 'customerId';
    protected $model = 'Shop\Model\Customer';
    protected $hydrator = 'Shop\Hydrator\Customer';
    
    public function search(array $search, $sort, Select $select = null)
    {	
    	if (str_replace('-', '', $sort) == 'name') {
    		if (strchr($sort,'-')) {
    			$sort = array('-lastname', '-firstname');
    		} else {
    			$sort = array('lastname', 'firstname');
    		}
    	}
    	 
    	return parent::search($search, $sort);
    }
    
    public function getDeliveryAddress($id)
    {
    	$id = (int) $id;
    
    	$select = $this->getSql()->select();
    	$select->from($this->table)
    	->join(
    		'customerAddress',
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
    
    public function getBillingAddress($id)
    {
    	$id = (int) $id;
    
    	$select = $this->getSql()->select();
    	$select->from($this->table)
    	->join(
    		'customerAddress',
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
