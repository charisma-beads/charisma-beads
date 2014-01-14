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
    
    public function searchCustomers($customer, $address, $sort)
    {
    	$select = $this->getSql()->select();
    	$select->from($this->table);
    	 
    	if (!$customer == '') {
    		if (substr($customer, 0, 1) == '=') {
    			$id = (int) substr($customer, 1);
    			$select->where->equalTo($this->primary, $id);
    		} else {
    			$searchTerms = explode(' ', $customer);
    			$where = $select->where->nest();
    
    			foreach ($searchTerms as $value) {
    				$where->like('firstname', '%'.$value.'%')
    					->or
    					->like('lastname',  '%'.$value.'%');
    			}
    
    			$where->unnest();
    		}
    	}
    	 
    	if (!$address == '') {
    		$select->where
    		->nest()
    		->like('address', '%'.$address.'%')
    		->unnest();
    	}
    	
    	if (str_replace('-', '', $sort) == 'name') {
    		if (strchr($sort,'-')) {
    			$sort = array('-lastname', '-firstname');
    		} else {
    			$sort = array('lastname', 'firstname');
    		}
    	}
    	 
    	$select = $this->setSortOrder($select, $sort);
    
    	return $this->fetchResult($select);
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
