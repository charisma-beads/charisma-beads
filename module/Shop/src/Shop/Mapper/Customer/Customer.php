<?php
namespace Shop\Mapper\Customer;

use UthandoCommon\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Select;

class Customer extends AbstractDbMapper
{
    /**
     * @var string
     */
    protected $table = 'customer';

    /**
     * @var string
     */
    protected $primary = 'customerId';

    /**
     * @param array $search
     * @param string $sort
     * @param Select $select
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function search(array $search, $sort, $select = null)
    {	
    	if (str_replace('-', '', $sort) == 'name') {
    		if (strchr($sort,'-')) {
    			$sort = array('-lastname', '-firstname');
    		} else {
    			$sort = array('lastname', 'firstname');
    		}
    	}
    	
    	$select = $this->getSelect();
    	
    	$select->join(
    	    'customerAddress',
    	    'customer.customerId=customerAddress.customerId',
    	    array(),
    	    Select::JOIN_LEFT
    	);
    	 
    	return parent::search($search, $sort, $select);
    }

    /**
     * @param $userId
     * @return \Shop\Model\Customer\Customer
     */
    public function getCustomerByUserId($userId)
    {
        $select = $this->getSelect();
        $select->where->equalTo('userId', $userId);
        $resultSet = $this->fetchResult($select);
        $row = $resultSet->current();
        return $row;
    }

    /**
     * @param $start
     * @param $end
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getCustomersByDate($start, $end)
    {
        $select = $this->getSelect();
        $select->where->between('dateCreated', $start, $end);
        $select = $this->setSortOrder($select, '-dateCreated');
        $resultSet = $this->fetchResult($select);
        return $resultSet;
    }
}
