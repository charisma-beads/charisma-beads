<?php

namespace Newsletter\Mapper;

use Common\Mapper\AbstractDbMapper;


class NewsletterMapper extends AbstractDbMapper
{
    protected $table = 'newsletter';
    protected $primary = 'newsletterId';

    /**
     * @return \Laminas\Db\ResultSet\HydratingResultSet|\Laminas\Db\ResultSet\ResultSet|\Laminas\Paginator\Paginator
     */
    public function fetchAllVisible()
    {
        $select = $this->getSelect();
        $select->where->equalTo('visible', 1);

        $rowSet = $this->fetchResult($select);
        return $rowSet;
    }
}