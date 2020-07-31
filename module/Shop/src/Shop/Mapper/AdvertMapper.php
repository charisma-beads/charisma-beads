<?php

namespace Shop\Mapper;

use Common\Mapper\AbstractDbMapper;
use Laminas\Db\Sql\Expression;
use Laminas\Db\ResultSet\ResultSet;

/**
 * Class Advert
 *
 * @package Shop\Mapper\Advert
 */
class AdvertMapper extends AbstractDbMapper
{
    protected $table = 'advert';
    protected $primary = 'advertId';

    /**
     * @return \Laminas\Db\ResultSet\HydratingResultSet|ResultSet|\Laminas\Paginator\Paginator
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

