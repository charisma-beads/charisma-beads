<?php

namespace Newsletter\Mapper;

use Common\Mapper\AbstractDbMapper;


class NewsletterMapper extends AbstractDbMapper
{
    protected $table = 'newsletter';
    protected $primary = 'newsletterId';

    /**
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function fetchAllVisible()
    {
        $select = $this->getSelect();
        $select->where->equalTo('visible', 1);

        $rowSet = $this->fetchResult($select);
        return $rowSet;
    }
}