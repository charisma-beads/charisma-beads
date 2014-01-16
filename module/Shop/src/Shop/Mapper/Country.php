<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractMapper;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;

class Country extends AbstractMapper
{
    protected $table = 'country';
    protected $primary = 'countryId';
    protected $model = 'Shop\Model\Country';
    protected $hydrator = 'Shop\Hydrator\Country';
    
    public function searchCountries($country, $sort)
    {
    	$select = $this->getSql()->select($this->table);
    	$select->join(
    		'postZone',
    		'country.postZoneId=postZone.postZoneId',
			array('postZone.zone' => 'zone'),
    		Select::JOIN_INNER
    	);
    	
    	if (!$country == '') {
    		if (substr($country, 0, 1) == '=') {
    			$id = (int) substr($country, 1);
    			$select->where->equalTo($this->primary, $id);
    		} else {
    			$searchTerms = explode(' ', $country);
    			$where = $select->where->nest();
    	
    			foreach ($searchTerms as $value) {
    				$where->like('country', '%'.$value.'%');
    			}
    	
    			$where->unnest();
    		}
    	}
    	
    	$select = $this->setSortOrder($select, $sort);
    	
    	return $this->fetchResult($select);
    }
    
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
