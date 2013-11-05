<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractMapper;
use Zend\Db\Sql\Select;

class CustomerAddress extends AbstractMapper
{
    protected $table = 'customerAddress';
    protected $primary = 'customerAddressId';
    protected $model = 'Shop\Model\CustomerAddress';
    protected $hydrator = 'Shop\Hydrator\CustomerAddress';
    
    public function getUserDeliveryAddress($id)
    {
        $id = (int) $id;
        
        $select = $this->getSql()->select();
		$select->from($this->table)
		->join(
		    'customerDeliveryAddress',
            'customerAddress.customerAddressId = customerDeliveryAddress.customerAddressId',
			array(),
			Select::JOIN_LEFT
		)->where
		->equalTo('userId', $id);
		
		return $this->fetchAll($select);
    }
    
    public function getUserBillingAddress($id)
    {
    	$id = (int) $id;
    
    	$select = $this->getSql()->select();
    	$select->from($this->table)
    	->join(
    		'customerBillingAddress',
    		'customerAddress.customerAddressId = customerBillingAddress.customerAddressId',
    		array(),
    		Select::JOIN_LEFT
    	)->where
    	->equalTo('userId', $id);
    
    	return $this->fetchAll($select);
    }
}
