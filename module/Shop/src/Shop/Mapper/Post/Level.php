<?php
namespace Shop\Mapper\Post;

use Application\Mapper\AbstractMapper;

class Level extends AbstractMapper
{
    protected $table = 'postLevel';
    protected $primary = 'postLevelId';
    protected $model = 'Shop\Model\Post\Level';
    protected $hydrator = 'Shop\Hydrator\Post\Level';
    
    public function searchLevels($level, $sort)
    {
    	$select = $this->getSelect();
    	
    	if (!$level == '') {
    		if (substr($level, 0, 1) == '=') {
    			$id = (int) substr($level, 1);
    			$select->where->equalTo($this->primary, $id);
    		} else {
    			$searchTerms = explode(' ', $level);
    			$where = $select->where->nest();
    	
    			foreach ($searchTerms as $value) {
    				$where->like('postLevel', '%'.$value.'%');
    			}
    	
    			$where->unnest();
    		}
    	}
    	
    	$select = $this->setSortOrder($select, $sort);
    	
    	return $this->fetchResult($select);
    }
}
