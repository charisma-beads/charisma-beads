<?php
namespace Shop\Mapper\Advert;

use UthandoCommon\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Expression;
use Zend\Db\ResultSet\ResultSet;

class Advert extends AbstractDbMapper
{
    protected $table = 'advert';
    protected $primary = 'advertId';

    /**
     * @return \Zend\Db\ResultSet\HydratingResultSet|ResultSet|\Zend\Paginator\Paginator
     */
    public function getStats()
    {
        $select = $this->getSelect();
        $select->columns([
            'advert',
            'numAdHits' => new Expression('(COUNT(advertHit.advertId))'),
            'totalHits' => new Expression('(SELECT COUNT(*) FROM advertHit)'),
        ])->join(
            'advertHit',
            'advert.advertId=advertHit.advertId',
            []
        )->group('advertHit.advertId');
        
        return $this->fetchResult($select, new ResultSet());
    }
}

