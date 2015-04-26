<?php
namespace Shop\Mapper\Advert;

use UthandoCommon\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Expression;
use Zend\Db\ResultSet\ResultSet;

class Advert extends AbstractDbMapper
{
    protected $table = 'advert';
    protected $primary = 'advertId';
    
    public function getStats()
    {
        /**
         * SELECT advert, COUNT(advertHit.advertId), ( SELECT COUNT(*) FROM advertHit ) 
         * FROM advertHit, advert 
         * WHERE advert.advertId=advertHit.advertId 
         * GROUP BY advertHit.advertId 
         */
    
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

