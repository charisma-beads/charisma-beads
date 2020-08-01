<?php

namespace News\Mapper;

use Common\Mapper\AbstractDbMapper;
use News\Model\NewsModel as NewsModel;
use Laminas\Db\Sql\Select;


class NewsMapper extends AbstractDbMapper
{
    protected $table = 'news';
    protected $primary = 'newsId';

    /**
     * @param $slug
     * @return null|NewsModel
     */
    public function getBySlug($slug)
    {
        $select = $this->getSelect();
        $select->where(['slug' => $slug]);

        $rowSet = $this->fetchResult($select);
        $row = $rowSet->current();

        return $row;
    }

    /**
     * @param array $search
     * @param string $sort
     * @param null $select
     * @return \Laminas\Db\ResultSet\HydratingResultSet|\Laminas\Db\ResultSet\ResultSet|\Laminas\Paginator\Paginator
     */
    public function search(array $search, $sort, $select = null)
    {
        $select = $this->getSelect();
    
        return parent::search($search, $sort, $select);
    }

    /**
     * @param int $limit
     * @return \Laminas\Db\ResultSet\HydratingResultSet|\Laminas\Db\ResultSet\ResultSet|\Laminas\Paginator\Paginator
     */
    public function getNewsByHits(int $limit)
    {
        $select = $this->getSelect();
        $select = $this->setLimit($select, $limit, 0);
        $select = $this->setSortOrder($select, '-pageHits');

        $rowSet = $this->fetchResult($select);

        return $rowSet;
    }

    /**
     * @param int $limit
     * @param string $sort
     * @return \Laminas\Db\ResultSet\HydratingResultSet|\Laminas\Db\ResultSet\ResultSet|\Laminas\Paginator\Paginator
     */
    public function getNewsByDate(int $limit, string $sort = '-')
    {
        $select = $this->getSelect();
        $select = $this->setLimit($select, $limit, 0);
        $select = $this->setSortOrder($select, $sort . 'dateCreated');

        $rowSet = $this->fetchResult($select);

        return $rowSet;
    }
} 