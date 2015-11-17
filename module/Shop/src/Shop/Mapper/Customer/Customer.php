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
 * Class Customer
 *
 * @package Shop\Mapper\Customer
 */
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
    	
    	$select = $this->getSelect()
            ->quantifier(Select::QUANTIFIER_DISTINCT);
    	
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
