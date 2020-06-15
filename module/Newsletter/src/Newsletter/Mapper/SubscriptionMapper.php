<?php

namespace Newsletter\Mapper;

use Common\Mapper\AbstractDbMapper;


class SubscriptionMapper extends AbstractDbMapper
{
    protected $table = 'newsletterSubscription';
    protected $primary = 'subscriptionId';

    /**
     * @param $id
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getSubscriptionsBySubscriberId($id)
    {
        $select = $this->getSelect();
        $select->where->equalTo('subscriberId', $id);

        $rowSet = $this->fetchResult($select);
        return $rowSet;
    }

    /**
     * @param $id
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getSubscriptionsByNewsletterId($id)
    {
        $select = $this->getSelect();
        $select->where->equalTo('newsletterId', $id);

        $rowSet = $this->fetchResult($select);

        return $rowSet;
    }
}