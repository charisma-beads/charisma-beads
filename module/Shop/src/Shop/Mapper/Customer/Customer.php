<?php
namespace Shop\Mapper\Customer;

use UthandoCommon\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Select;

class Customer extends AbstractDbMapper
{
    protected $table = 'customer';
    protected $primary = 'customerId';
    
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
    
    public function getCustomerByUserId($userId)
    {
        $select = $this->getSelect();
        $select->where->equalTo('userId', $userId);
        $resultSet = $this->fetchResult($select);
        $row = $resultSet->current();
        return $row;
    }
}
