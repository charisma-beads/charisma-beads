<?php
namespace Shop\Mapper\Post;

use Application\Mapper\AbstractMapper;

class Zone extends AbstractMapper
{
    protected $table = 'postZone';
    protected $primary = 'postZoneId';
    protected $model = 'Shop\Model\Post\Zone';
    protected $hydrator = 'Shop\Hydrator\Post\Zone';
    
    public function searchZones($zone, $sort)
    {
    	$select = $this->getSql()->select();
    	$select->from($this->table);
    	 
    	if (!$zone == '') {
    		if (substr($zone, 0, 1) == '=') {
    			$id = (int) substr($zone, 1);
    			$select->where->equalTo($this->primary, $id);
    		} else {
    			$searchTerms = explode(' ', $zone);
    			$where = $select->where->nest();
    			 
    			foreach ($searchTerms as $value) {
    				$where->like('zone', '%'.$value.'%');
    			}
    			 
    			$where->unnest();
    		}
    	}
    	 
    	$select = $this->setSortOrder($select, $sort);
    	 
    	return $this->fetchResult($select);
    }
}
