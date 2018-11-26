<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Mapper\Advert
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Mapper;

use UthandoCommon\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Expression;
use Zend\Db\ResultSet\ResultSet;

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

