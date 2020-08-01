<?php

namespace Article\Mapper;

use Common\Mapper\AbstractDbMapper;


class ArticleMapper extends AbstractDbMapper
{
    protected $table = 'article';
    protected $primary = 'articleId';

    /**
     * @param string $slug
     * @return array|\ArrayObject|null|object
     */
    public function getArticleBySlug($slug)
    {
        $select = $this->getSelect()->where(['slug' => $slug]);
        $rowSet = $this->fetchResult($select);
        $row = $rowSet->current();
        return $row;
    }

    /**
     * @param $limit
     * @return \Laminas\Db\ResultSet\HydratingResultSet|\Laminas\Db\ResultSet\ResultSet|\Laminas\Paginator\Paginator
     */
    public function getArticlesByDate($limit)
    {
        $select = $this->getSelect();
        $select = $this->setLimit($select, $limit, 0);
        $select = $this->setSortOrder($select, '-dateCreated');

        $rowSet = $this->fetchResult($select);

        return $rowSet;
    }
}