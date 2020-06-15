<?php

namespace Mail\Mapper;

use Common\Mapper\AbstractDbMapper;


class MailQueueMapper extends AbstractDbMapper
{
    protected $table = 'mailQueue';
    protected $primary = 'mailQueueId';

    /**
     * @param int $limit
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getMailsInQueue($limit)
    {
        $select = $this->getSelect();
        $select = $this->setLimit($select, $limit, 0);
        $select = $this->setSortOrder($select, 'priority');

        return $this->fetchResult($select);
    }
}
