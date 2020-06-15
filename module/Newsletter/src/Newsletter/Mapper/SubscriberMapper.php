<?php

namespace Newsletter\Mapper;

use Common\Mapper\AbstractDbMapper;


class SubscriberMapper extends AbstractDbMapper
{
    protected $table = 'newsletterSubscriber';
    protected $primary = 'subscriberId';

    /**
     * @param $email
     * @return array|\Common\Model\ModelInterface
     */
    public function getByEmail($email)
    {
        return $this->getById($email, 'email');
    }

    /**
     * @param array $ids
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getSubscribersById(array $ids)
    {
        $select = $this->getSelect();
        $select->where->in('subscriberId', $ids);

        $rowSet = $this->fetchResult($select);

        return $rowSet;
    }
}