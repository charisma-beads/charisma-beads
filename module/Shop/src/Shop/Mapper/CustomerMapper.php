<?php

namespace Shop\Mapper;

use Common\Mapper\AbstractDbMapper;
use Laminas\Db\Sql\Select;

/**
 * Class Customer
 *
 * @package Shop\Mapper
 */
class CustomerMapper extends AbstractDbMapper
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
     * @return \Laminas\Db\ResultSet\HydratingResultSet|\Laminas\Db\ResultSet\ResultSet|\Laminas\Paginator\Paginator
     */
    public function search(array $search, $sort, $select = null)
    {
        if (str_replace('-', '', $sort) == 'name') {
            if (strchr($sort, '-')) {
                $sort = ['-lastname', '-firstname'];
            } else {
                $sort = ['lastname', 'firstname'];
            }
        }

        $select = $this->getSelect()
            ->quantifier(Select::QUANTIFIER_DISTINCT);

        $select->join(
            'customerAddress',
            'customer.customerId=customerAddress.customerId',
            [],
            Select::JOIN_LEFT
        );

        return parent::search($search, $sort, $select);
    }

    /**
     * @param $userId
     * @return \Shop\Model\CustomerModel
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
     * @return \Laminas\Db\ResultSet\HydratingResultSet|\Laminas\Db\ResultSet\ResultSet|\Laminas\Paginator\Paginator
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
