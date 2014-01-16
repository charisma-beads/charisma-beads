<?php
namespace Shop\Mapper\Post;

use Application\Mapper\AbstractMapper;
use Zend\Db\Sql\Select;

class Cost extends AbstractMapper
{
    protected $table = 'postCost';
    protected $primary = 'postCostId';
    protected $model = 'Shop\Model\Post\Cost';
    protected $hydrator = 'Shop\Hydrator\Post\Cost';
    
    public function searchCosts($cost, $sort)
    {
    	$select = $this->getSql()->select($this->table);
    	
    	$select->join(
	    	'postLevel',
	    	'postCost.postLevelId=postLevel.postLevelId',
	    	array('postLevel'),
	    	Select::JOIN_INNER
	    )
	    ->join(
	    	'postZone',
	    	'postCost.postZoneId=postZone.postZoneId',
	    	array('zone'),
	    	Select::JOIN_LEFT
	    );
    	 
    	if (!$cost == '') {
    		if (substr($cost, 0, 1) == '=') {
    			$id = (int) substr($cost, 1);
    			$select->where->equalTo($this->getPrimaryKey(), $id);
    		} else {
    			$searchTerms = explode(' ', $cost);
    			$where = $select->where->nest();
    			 
    			foreach ($searchTerms as $value) {
    				$where->like('cost', '%'.$value.'%');
    			}
    			 
    			$where->unnest();
    		}
    	}
    	 
    	$select = $this->setSortOrder($select, $sort);
    	 
    	return $this->fetchResult($select);
    }
}
