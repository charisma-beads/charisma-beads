<?php
namespace Shop\Mapper\Post;

use Application\Mapper\AbstractMapper;

class Cost extends AbstractMapper
{
    protected $table = 'postCost';
    protected $primary = 'postCostId';
    protected $model = 'Shop\Model\Post\Cost';
    protected $hydrator = 'Shop\Hydrator\Post\Cost';
    
    public function searchCosts($cost, $sort)
    {
    	$select = $this->getSelect();
    	 
    	if (!$cost == '') {
    		if (substr($cost, 0, 1) == '=') {
    			$id = (int) substr($cost, 1);
    			$select->where->equalTo($this->primary, $id);
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
