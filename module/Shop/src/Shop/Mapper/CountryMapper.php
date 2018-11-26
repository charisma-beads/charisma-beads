<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Mapper\Country
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2015 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Mapper;

use UthandoCommon\Mapper\AbstractDbMapper;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;

/**
 * Class Country
 *
 * @package Shop\Mapper
 */
class CountryMapper extends AbstractDbMapper
{
    protected $table = 'country';
    protected $primary = 'countryId';

    /**
     * @param array $search
     * @param string $sort
     * @param null $select
     * @return \Zend\Db\ResultSet\HydratingResultSet|ResultSet|\Zend\Paginator\Paginator
     */
    public function search(array $search, $sort, $select = null)
    {
    	$select = $this->getSql()->select($this->table);
    	$select->join(
    		'postZone',
    		'country.postZoneId=postZone.postZoneId',
			array('postZone.zone' => 'zone'),
    		Select::JOIN_INNER
    	);
    	
    	return parent::search($search, $sort, $select);
    }

    /**
     * @param $code
     * @return null|\Shop\Model\CountryModel
     */
    public function getCountryByCountryCode($code)
    {
        $code = (string) $code;

        $select = $this->getSelect();
        $select->where->equalTo('code', $code);
        $resultSet = $this->fetchResult($select);
        $row = $resultSet->current();

        return $row;
    }

    /**
     * @param $id
     * @return \Zend\Db\ResultSet\HydratingResultSet|ResultSet|\Zend\Paginator\Paginator
     */
    public function getCountryPostalRates($id)
    {
        $select = $this->getSql()->select();
        
        $select->from($this->table)
        ->join(
            'postZone',
            'postZone.postZoneId=country.postZoneId',
            array(),
            Select::JOIN_INNER   
        )->join(
        	'postCost',
            'postCost.postZoneId=postZone.postZoneId',
            array('cost', 'vatInc'),
            Select::JOIN_INNER
        )->join(
        	'postLevel',
            'postLevel.postLevelId=postCost.postLevelId',
            array('postLevel'),
            Select::JOIN_INNER
        )->join(
        	'taxCode',
            'taxCode.taxCodeId=postZone.taxCodeId',
            array(),
            Select::JOIN_INNER
        )->join(
        	'taxRate',
            'taxRate.taxRateId=taxCode.taxRateId',
            array('taxRate'),
            Select::JOIN_INNER
        )->where->equalTo('country.countryId', $id);
        
        $select = $this->setSortOrder($select, 'postLevel');
        
        return $this->fetchResult($select, new ResultSet());
    }
}
